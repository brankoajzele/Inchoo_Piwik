<?php

class Inchoo_Piwik_Adminhtml_Inchoo_Piwik_WidgetController extends Mage_Adminhtml_Controller_Action 
{
    public function indexAction() 
    {
        $this->loadLayout();

        $helper = Mage::helper('inchoo_piwik');
        
        $tokenAuth = $helper->getTokenAuth();

        if (!empty($tokenAuth)) {
            
            $piwikWidget = $this->getLayout()
                                ->createBlock('core/text', 'inchoo_piwik_widget')
                                ->setText(sprintf('<iframe src="%s/index.php?module=Widgetize&action=iframe&moduleToWidgetize=Dashboard&actionToWidgetize=index&idSite=%s&period=week&date=yesterday&token_auth=%s" frameborder="0" marginheight="0" marginwidth="0" width="100%%" height="1000px"></iframe>', $helper->getPiwikBaseUrl(), $helper->getSiteId(), $tokenAuth));
            
            $this->_addContent($piwikWidget);
            $this->_setActiveMenu('report')->renderLayout();
        }

        if (empty($tokenAuth)) {
            Mage::getSingleton('adminhtml/session')->addWarning(
                    Mage::helper('adminhtml')->__('Piwik Token Auth Key is missing. Please set it up under "System > Configuration > Sales > Piwik Analytics > Piwik Analytics Settings > Token Auth" in order to use this functionality.'));
            
            $this->_redirect('/');            
        }
    }

    public function testAction() 
    {
        exit('testAction');
    }

}