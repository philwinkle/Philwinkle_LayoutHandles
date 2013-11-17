<?php
class Philwinkle_LayoutHandles_Model_Observer
{
    public $handles = array();
    public $update;


    /**
     * Adding all implemented handles
     * @todo  Implement as a strategy pattern
     * @todo  Unify preg_match and stripos positions
     * @param Varien_Event_Observer $observer
     */
    public function addHandles(Varien_Event_Observer $observer)
    {
        $this->update = $observer->getEvent()->getLayout()->getUpdate();
        $this->collectHandles()->processHandles();

        return $this;
    }

    public function collectHandles()
    {
        $this->operatingSystemHandle();
        $this->browserHandle();

        return $this;
    }

    public function processHandles()
    {
        foreach($this->handles as $handle){
            $this->update->addHandle($handle);
        }

        return $this;
    }

    public function operatingSystemHandle()
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

        $this->handles[] = 'operating_system_' . $os;
    }

    public function browserHandle()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        if ( stripos($agent, 'Firefox') !== false ) {
            $agent = 'firefox';
        } elseif ( stripos($agent, 'MSIE') !== false ) {
            $agent = 'ie';
        } elseif ( stripos($agent, 'iPad') !== false ) {
            $agent = 'ipad';
        } elseif ( stripos($agent, 'Android') !== false ) {
            $agent = 'android';
        } elseif ( stripos($agent, 'Chrome') !== false ) {
            $agent = 'chrome';
        } elseif ( stripos($agent, 'Safari') !== false ) {
            $agent = 'safari';
        }

        $this->handles[] = 'browser_' . $agent;
    }

}