<?php
class Clevermage_Robot_Model_Resource_Steperror extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {    
        $this->_init('clevermage_robot/steperror', 'id');
    }
}