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



class Mirasvit_Helpdesk_Adminhtml_ArchiveController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_redirect('helpdeskadmin/adminhtml_ticket/index', array('is_archive' => 1));
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('helpdesk/archive');
    }
}