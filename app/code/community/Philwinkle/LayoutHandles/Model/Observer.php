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
     * @return  Philwinkle_LayoutHandles_Model_Observer
     */
    public function addHandles(Varien_Event_Observer $observer)
    {
        $this->update = $observer->getEvent()->getLayout()->getUpdate();
        $this->collectHandles()->processHandles();

        return $this;
    }

    /**
     * Collect defined handles from within this observer
     * @return Philwinkle_LayoutHandles_Model_Observer 
     */
    public function collectHandles()
    {
        $this->operatingSystemHandle();
        $this->browserHandle();

        return $this;
    }

    /**
     * Process defined handles and add to the loaded layout update
     * @return Philwinkle_LayoutHandles_Model_Observer
     */
    public function processHandles()
    {
        foreach($this->handles as $handle){
            $this->update->addHandle($handle);
        }

        return $this;
    }


    /**
     * Add a handle for operating systems, e.g.:
     * <layout>
     *   <operating_system_linux>
     *   </operating_system_linux>
     * </layout>
     * @see  http://stackoverflow.com/a/4105118/582138
     * @return Philwinkle_LayoutHandles_Model_Observer
     */
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
            $os = null;
        }

        if($os){
            $this->handles[] = 'operating_system_' . $os;
        }
    }

    /**
     * Add layout handle for browser type, e.g.:
     * <layout>
     *   <browser_firefox>
     *   </browser_firefox>
     * </layout>
     * @see  http://stackoverflow.com/a/9693781/582138
     * @return Philwinkle_LayoutHandles_Model_Observer
     */
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
        } else {
            $agent = null;
        }

        if($agent){
            $this->handles[] = 'browser_' . $agent;
        }

        return $this;
    }

}