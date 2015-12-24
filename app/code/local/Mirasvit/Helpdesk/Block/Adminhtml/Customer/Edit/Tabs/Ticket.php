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



class Mirasvit_Helpdesk_Block_Adminhtml_Customer_Edit_Tabs_Ticket extends Mage_Adminhtml_Block_Widget
implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getTabLabel()
    {
        return Mage::helper('helpdesk')->__('Help Desk Tickets');
    }

    public function getTabTitle()
    {
        return Mage::helper('helpdesk')->__('Help Desk Tickets');
    }

    public function canShowTab()
    {
        return $this->getId() ? true : false;
    }

    public function getId()
    {
        return $this->getRequest()->getParam('id');
    }

    public function isHidden()
    {
        return false;
    }

    protected function _toHtml()
    {
        $customer = Mage::registry('current_customer');
        if (!$this->getId() || !$customer) {
            return '';
        }
        $id = $this->getId();
        $ticketNewUrl = $this->getUrl('helpdeskadmin/adminhtml_ticket/add', array('customer_id' => $id));

        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setClass('add')
            ->setType('button')
            ->setOnClick('window.location.href=\''.$ticketNewUrl.'\'')
            ->setLabel($this->__('Create ticket for this customer'));

        $grid = $this->getLayout()->createBlock('helpdesk/adminhtml_ticket_grid');
        // $grid->addCustomFilter('customer_id', $id);
        $grid->addCustomFilter('customer_email = "'.addslashes($customer->getEmail()).'" OR customer_id='.(int) $id);
        $grid->setId('helpdesk_grid_customer');
        $grid->removeFilter('is_archived');
        $grid->setFilterVisibility(false);
        $grid->setPagerVisibility(0);
        $grid->setTabMode(true);
        $grid->setActiveTab('tickets');

        return '<div>'.$button->toHtml().'<br><br>'.$grid->toHtml().'</div>';

        // return '<div class="content-buttons-placeholder" style="height:25px;">' .
        // '<p class="content-buttons form-buttons" >' . $button->toHtml() . '</p>' .
        // '</div>' . $grid->toHtml();
    }
}
