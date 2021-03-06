<?php

/**
 * Zing
 *
 * @category  Zing
 * @package   Contactus
 * @version   1.0.0
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

            $mail = Mage::getModel('core/email')
                    ->setToName('Cesar Felipe')
                    ->setToEmail('felipe@clevermage.com')
                    ->setBody($processedTemplate)
                    ->setSubject($emailTemplateVariables['subject'])
                    ->setFromEmail($emailTemplateVariables['mail'])
                    ->setFromName($emailTemplateVariables['name'])
                    ->setType('html');
            $mail->send();
            //$emailTemplate->send('felipe@clevermage.com', 'Cesar Felipe', $emailTemplateVariables);

            Mage::getSingleton('core/session')->addSuccess('Your message has been successfully sent.');
        }
        catch (\Exception $ex) {
            echo '<pre>';
            print_r($ex);
            die;
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
