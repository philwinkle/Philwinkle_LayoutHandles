<?php
class Philwinkle_LayoutHandles_Model_Observer
{
    public function addHandle(Varien_Event_Observer $observer)
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        if(preg_match('/Linux/',$agent)){
            $os = 'linux';
        } elseif(preg_match('/Win/',$agent)){
            $os = 'windows';
        } elseif(preg_match('/Mac/',$agent)){
            $os = 'osx';
        } else {
            $os = 'unknown';
        }

        /* @var $update Mage_Core_Model_Layout_Update */
        $update = $observer->getEvent()->getLayout()->getUpdate();
        $update->addHandle('operating_system_' . $os);
    }
}