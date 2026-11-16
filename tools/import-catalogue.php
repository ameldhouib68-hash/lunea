<?php
/** Import local uniquement, à exécuter avec PHP CLI, jamais via le navigateur. */
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
if ($argc !== 3 || !ctype_digit($argv[2])) {
    fwrite(STDERR, "Usage : php import-catalogue.php RACINE_PRESTASHOP ID_REGLE_TAXE\n"); exit(1);
}
$root = realpath($argv[1]);
if (!$root || !is_file($root.'/config/config.inc.php')) { throw new RuntimeException('Racine PrestaShop invalide.'); }
require $root.'/config/config.inc.php';
if (version_compare(_PS_VERSION_, '9.0.0', '<')) { throw new RuntimeException('PrestaShop 9 requis.'); }
$host = Configuration::get('PS_SHOP_DOMAIN');
if (!in_array(explode(':', $host)[0], ['localhost', '127.0.0.1'], true)) { throw new RuntimeException('Boutique localhost requise.'); }
$context = Context::getContext();
if (Shop::isFeatureActive()) { throw new RuntimeException('Multiboutique non prise en charge.'); }
if ($context->currency->iso_code !== 'EUR') { throw new RuntimeException('Configurer EUR avant import.'); }
$taxId = (int)$argv[2];
if ($taxId && !Validate::isLoadedObject(new TaxRulesGroup($taxId))) { throw new RuntimeException('Règle de taxe inconnue.'); }
if ($taxId && !Configuration::get('PS_TAX')) { throw new RuntimeException('Activer les taxes avant utilisation de cette règle.'); }
$address = new Address();
$address->id_country = (int)Configuration::get('PS_COUNTRY_DEFAULT');
$rate = $taxId ? TaxManagerFactory::getManager($address, $taxId)->getTaxCalculator()->getTotalRate() : 0;
$catalogue = json_decode(file_get_contents(__DIR__.'/../data/catalogue.json'), true, 512, JSON_THROW_ON_ERROR);
$db = Db::getInstance();
foreach ($catalogue as $item) {
    if ($db->getValue('SELECT id_product FROM `'._DB_PREFIX_."product` WHERE reference='".pSQL($item['reference'])."'")) {
        throw new RuntimeException('Référence déjà présente : '.$item['reference'].'. Aucun import lancé.');
    }
}
function translations($text) {
    $out = [];
    foreach (Language::getLanguages(false) as $lang) { $out[(int)$lang['id_lang']] = $text; }
    return $out;
}
function saveNew($object) {
    if (!$object->add()) { throw new RuntimeException('Échec de création '.get_class($object)); }
    return (int)$object->id;
}
// Les produits créés restent en brouillon. Pas de suppression de données existantes.
$category = new Category();
$category->name = translations('Collection LUNÉA');
$category->link_rewrite = translations('collection-lunea');
$category->id_parent = (int)Configuration::get('PS_HOME_CATEGORY');
$category->active = true;
$categoryId = saveNew($category);
Configuration::updateValue('LUNEA_COLLECTION_ID', $categoryId);
$group = new AttributeGroup();
$group->name = translations('Finition LUNÉA');
$group->public_name = translations('Couleur');
$group->group_type = 'select';
$group->is_color_group = false;
$groupId = saveNew($group);
$colors = [];
foreach ($catalogue as $item) {
    $product = new Product();
    $product->name = translations($item['name']);
    $product->link_rewrite = translations(Tools::link_rewrite($item['name']));
    $product->reference = $item['reference'];
    $product->price = round($item['price_ttc_eur'] / (1 + $rate / 100), 6);
    $product->id_tax_rules_group = $taxId;
    $product->id_category_default = $categoryId;
    $product->active = false;
    $product->available_for_order = true;
    $product->show_price = true;
    $product->visibility = 'both';
    $product->minimal_quantity = 1;
    $product->condition = 'new';
    $product->description_short = translations('<p>'.htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8').'</p>');
    $html = '<p>'.htmlspecialchars($item['notice'], ENT_QUOTES, 'UTF-8').'</p><ul>';
    foreach ($item['features'] as $key => $value) {
        $html .= '<li>'.htmlspecialchars($key.' : '.$value, ENT_QUOTES, 'UTF-8').'</li>';
    }
    $html .= '</ul><p>'.htmlspecialchars($item['delivery'], ENT_QUOTES, 'UTF-8').'</p>';
    $product->description = translations($html);
    $productId = saveNew($product);
    if (!$product->addToCategories([$categoryId])) { throw new RuntimeException('Association catégorie impossible.'); }
    foreach ($item['variants'] as $index => $variant) {
        if (!isset($colors[$variant['color']])) {
            $attribute = new PrestaShopAttribute();
            $attribute->id_attribute_group = $groupId;
            $attribute->name = translations($variant['color']);
            $colors[$variant['color']] = saveNew($attribute);
        }
        $combination = new Combination();
        $combination->id_product = $productId;
        $combination->reference = $variant['reference'];
        $combination->price = 0;
        $combination->minimal_quantity = 1;
        $combination->default_on = $index === 0 ? 1 : null;
        $combinationId = saveNew($combination);
        if (!$combination->setAttributes([$colors[$variant['color']]])) { throw new RuntimeException('Association couleur impossible.'); }
        StockAvailable::setQuantity($productId, $combinationId, (int)$variant['stock_demo']);
    }
    Product::updateDefaultAttribute($productId);
    StockAvailable::setProductOutOfStock($productId, 0);
    echo $item['name']." : brouillon créé.\n";
}
echo "Import terminé : contrôler prix TTC, déclinaisons et stocks dans le back-office avant activation.\n";
