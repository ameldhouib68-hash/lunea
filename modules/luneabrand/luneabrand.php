<?php
if (!defined('_PS_VERSION_')) { exit; }
class LuneaBrand extends Module
{
    public function __construct()
    {
        $this->name = 'luneabrand';
        $this->tab = 'front_office_features';
        $this->version = '0.1.0';
        $this->author = 'LUNÉA';
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = 'LUNÉA — identité';
        $this->description = 'Base visuelle du projet universitaire, sans paiement.';
        $this->ps_versions_compliancy = ['min' => '9.0.0', 'max' => '9.99.99'];
    }
    public function install()
    {
        return parent::install() && $this->registerHook('displayHome')
            && $this->registerHook('actionFrontControllerSetMedia');
    }
    public function hookActionFrontControllerSetMedia($params)
    {
        $this->context->controller->registerStylesheet('lunea-brand',
            'modules/'.$this->name.'/views/css/lunea.css', ['media' => 'all', 'priority' => 200]);
    }
    public function hookDisplayHome($params)
    {
        $id = (int) Configuration::get('LUNEA_COLLECTION_ID');
        $url = $id ? $this->context->link->getCategoryLink($id)
            : $this->context->link->getPageLink('search', null, null, ['s' => 'veilleuse']);
        $this->context->smarty->assign('lunea_collection_url', $url);
        return $this->display(__FILE__, 'views/templates/hook/home.tpl');
    }
}
