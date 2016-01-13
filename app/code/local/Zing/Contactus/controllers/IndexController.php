<?php

/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Help Desk MX
 * @version   1.1.5
 * @build     1709
 * @copyright Copyright (C) 2015 Mirasvit (http://mirasvit.com/)
 */
class Zing_Contactus_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        echo __CLASS__ . __FUNCTION__;
    }

    public function postAction()
    {
        try {
            $emailTemplateVariables = $this->getRequest()->getParams();

            $emailTemplate = Mage::getModel('core/email_template')
                    ->loadDefault('zing_custom_email_template1');


            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

            $emailTemplate->setSenderEmail($this->getRequest()->getParam('mail'));

            $emailTemplate->setSenderName($this->getRequest()->getParam('name'));

            $emailTemplate->send('itmyprofession@gmail.com', 'Santosh Moktan', $emailTemplateVariables);

            Mage::getSingleton('core/session')->addSuccess('Your message has been successfully sent.');
        }
        catch (\Exception $ex) {
            // I assume you have your custom module. 
            // If not, you may keep 'customer' instead of 'yourmodule'.
            Mage::getSingleton('core/session')
                    ->addError(Mage::helper('zing_contactus')
                            ->__('Unable to send email.'));
        }
        $refererUrl = $this->_getRefererUrl();
        $this->getResponse()->setRedirect($refererUrl);
        return $this;
    }

}
