<?php
class Clevermage_Robot_Model_Suite extends Mage_Core_Model_Abstract
{
	public $screen_sizes = array(
		'480x320',
		'320x480',
		'768x1024',
		'1024x768',
		'1280x1024',
	);

    public function _construct()
    {
        parent::_construct();
        $this->_init('clevermage_robot/suite');
    }

    public function runCasperJs(){
    	$sites = Mage::getModel('clevermage_robot/site')
			->getCollection()
			->addFieldToFilter('status', 1);
    	foreach ($sites as $site){
    		$values = Mage::getModel('clevermage_robot/value')
    			->getCollection()
				->addFieldToFilter('clevermage_robot_site_id', $site->getId());
    		$caspterJsScript = Mage::getBaseDir() . DS . "casperjs" . DS . "test.js";
    		$log = $this->getFolderLog() . DS . $site->getId() . '-'. date('Y_m_d__H_i_s') . ".xml";
    		$command = "/usr/local/bin/casperjs test " . $caspterJsScript . ' --xunit="' . $log . '" --ignore-ssl-errors=true --ssl-protocol=any';
    		$command .= " --id_client=" . $site->getId();
    		$command .= ' --base_dir="' . Mage::getBaseDir() .'"';
    		foreach ($values as $value){
    			$name = Mage::getModel('clevermage_robot/param')->load($value->getClevermageRobotParamId());
    			$command .= ' --' . $name->getName() . '="' . $value->getValue() . '"';
    		}
    		exec($command .' 2>&1');
    	}
    }

    public function saveCasperJsResult(){
    	foreach (new DirectoryIterator($this->getFolderLog()) as $fileInfo) {
    		if($fileInfo->isDot()) continue;
    		$site = Mage::getModel('clevermage_robot/site')->load(reset(explode('-', $fileInfo)));
    		if ($site->getId()){
	    		$log = simplexml_load_file($this->getFolderLog() . DS . $fileInfo);
	    		foreach ($log->testsuite as $suite){
	    			try{
		    			$suite_history = Mage::getModel('clevermage_robot/suitehistory')
		    				->getCollection()
							->addFieldToFilter('clevermage_robot_site_id', $site->getId())
							->addFieldToFilter('clevermage_robot_suite_id', $suite['name'])
							->getFirstItem();
						if (!$suite_history->getId()){

							$suite_history = Mage::getModel('clevermage_robot/suitehistory')->setData(array(
				    				'visits' => 1,
				    				'clevermage_robot_site_id' => $site->getId(),
				    				'clevermage_robot_suite_id' => $suite['name'],
			    				)
							);
							$suite_history = $suite_history->save();
						}else{
							$suite_history->setVisits($suite_history->getVisits() + 1);
							$suite_history->save();
						}
						foreach ($suite->testcase as $step){
					  		if ($step->failure){
					  			$created_at = new DateTime($suite['timestamp']);
								$failure = json_decode($step->failure);
								$step_error = Mage::getModel('clevermage_robot/steperror')->setData(array(
				    					'created_at' => $created_at->format('Y-m-d H:i:s'),
					    				'description' => $failure->msg,
					    				'image' => $failure->image,
					    				'clevermage_robot_step_id' => (string) $step['classname'],
					    				'clevermage_robot_suite_history_id' => $suite_history->getId()
			    					)
								);  	
								$step_error->save();
					  		}
						}
					}catch (Exception $e){
			    		echo $e->getMessage(); die;
					}
	    		}
	    		unlink($this->getFolderLog() . DS . $fileInfo);
    		}
		}	
    }

    public function getFolderLog(){
    	return Mage::getBaseDir() . DS . "media" . DS . "casperjs" . DS . "log" . DS;
    }

    public function getFolderScreenShots(){
    	return Mage::getBaseDir() . DS . 'media' . DS . 'casperjs' . DS . 'screen_shots' . DS;
    }

    public function getScreenShotUrl($name){
    	return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'casperjs' . DS . 'images' . DS . $name;
    }
}