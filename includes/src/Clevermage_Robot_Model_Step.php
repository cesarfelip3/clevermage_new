<?php
class Clevermage_Robot_Model_Step extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('clevermage_robot/step');
    }
}