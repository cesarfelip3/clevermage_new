<?php
class Clevermage_Robot_IndexController extends Mage_Core_Controller_Front_Action
{
	public function preDispatch()
	{
	    parent::preDispatch();
	    if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
	        $this->_redirect(Mage::getUrl('customer/account/login'));
	        return;
	    }
	}

    public function indexAction(){
    	if ($this->getRequest()->isXmlHttpRequest()) {
		    $page_size = 15;
		    $current_page = 1;
		    if ($this->getRequest()->getParam('start') and $this->getRequest()->getParam('start') > 0 and  $this->getRequest()->getParam('length') != '-1'){
		        $page_size = $this->getRequest()->getParam('length');
		        $current_page = ($this->getRequest()->getParam('start') / $page_size) + 1;
		    }
		    $customer = Mage::getSingleton('customer/session')->getCustomer();
			
			$customer_clients = Mage::getModel('clevermage_robot/customersite')
				->getCollection()
				->addFieldToFilter('customer_entity_id', $customer->getEntityId())
				->addFieldToFilter('clevermage_robot_site_id', $this->getRequest()->getParam('site'));
			if ($customer_clients->getSize() == 0){
				die('Error.');
			}

			$site = Mage::getModel('clevermage_robot/site')->load($this->getRequest()->getParam('site'));

		    $suite_histories = Mage::getModel('clevermage_robot/suitehistory')
				->getCollection()
				->addFieldToFilter('clevermage_robot_site_id', $site->getId())
				->setPageSize($page_size)
				->setCurPage($current_page)
				->setOrder('id', 'DESC');

			$total = Mage::getModel('clevermage_robot/suitehistory')
				->getCollection()
				->addFieldToFilter('clevermage_robot_site_id', $site->getId())
				->getSize();

			$output = array(
				"sEcho" => intval($this->getRequest()->getParam('sEcho')),
				"iTotalRecords" => $total,
				"iTotalDisplayRecords" => $suite_histories->getSize(),
				"aaData" => array()
    		);

    		foreach ($suite_histories as $suite_history){
    			$suite = Mage::getModel('clevermage_robot/suite')->load($suite_history->getClevermageRobotSuiteId());
    			
    			$step_errors = Mage::getModel('clevermage_robot/steperror')
    				->getCollection()
					->addFieldToFilter('clevermage_robot_suite_history_id', $suite_history->getId())
					->setOrder('created_at', 'DESC');

    			$row = array(
    				'suite' => $suite->getName(),
    				'visits' => $suite_history->getVisits(),
					'errors' => $step_errors->getSize()
    			);
    			$row['step_errors'] = array();
    			
				foreach ($step_errors as $step_error){
					$step = Mage::getModel('clevermage_robot/step')->load($step_error->getClevermageRobotStepId());
					$row['step_errors'][] = array(
						'name' => $step->getName(),
						'created_at' => $step_error->getCreatedAt(),
						'description' => $step_error->getDescription(),
						'image' => $suite->getScreenShotUrl($step_error->getImage())
					);
				}
    			$output['aaData'][] = $row;
    		}
     		echo json_encode($output); die;
    	}
    	$this->loadLayout();     
    	if ($navigationBlock = $this->getLayout()->getBlock('customer_account_navigation')) {
			$navigationBlock->setActive('robot/index/index');
		}
  		$this->renderLayout();
    }
}