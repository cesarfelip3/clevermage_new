<?php
class Clevermage_Robot_Model_Resource_Suite_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('clevermage_robot/suite');
    }
}