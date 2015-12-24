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



class Mirasvit_Helpdesk_Helper_Validator extends Mirasvit_MstCore_Helper_Validator_Abstract
{
    public function testAttachmentFilesystem()
    {
        $result = self::SUCCESS;
        $title = 'Filesystem for Attachments';
        $description = array();
        if (!is_writable(Mage::getBaseDir('media'))) {
            $result = self::FAILED;
            $description[] = 'Please, adjust permission for '.Mage::getBaseDir('media').' folder and make it writable. Otherwise, extension will not store attachments properly.';
        }

        return array($result, $title, $description);
    }

    public function testImapPHP()
    {
        $result = self::SUCCESS;
        $title = 'IMAP PHP';
        $description = array();
        if (!extension_loaded('imap')) {
            $result = self::FAILED;
            $description[] = 'Please, ask your hosting provider to enable IMAP extension in PHP configuration of your server. <br> Otherwise, helpdesk will not be able to fetch emails.';
        }

        return array($result, $title, $description);
    }

    public function testMagentoCrc()
    {
        $filter = array(
            'app/code/core/Mage/Core',
            'js',
        );

        return Mage::helper('mstcore/validator_crc')->testMagentoCrc($filter);
    }

    public function testMirasvitCrc()
    {
        $modules = array('Helpdesk');

        return Mage::helper('mstcore/validator_crc')->testMirasvitCrc($modules);
    }

    public function testISpeedCache()
    {
        $result = self::SUCCESS;
        $title = 'My_Ispeed';
        $description = array();
        if (Mage::helper('mstcore')->isModuleInstalled('My_Ispeed')) {
            $result = self::INFO;
            $description[] = 'Extension My_Ispeed is installed. Please, go to the Configuration > Settings > I-Speed > General Configuration and add \'helpdesk\' to the list of Ignored URLs. Then clear ALL cache.';
        }

        return array($result, $title, $description);
    }

    public function testMgtVarnishCache()
    {
        $result = self::SUCCESS;
        $title = 'Mgt_Varnish';
        $description = array();
        if (Mage::helper('mstcore')->isModuleInstalled('Mgt_Varnish')) {
            $result = self::INFO;
            $description[] = 'Extension Mgt_Varnish is installed. Please, go to the Configuration > Settings > MGT-COMMERCE.COM > Varnish and add \'helpdesk\' to the list of Excluded Routes. Then clear ALL cache.';
        }

        return array($result, $title, $description);
    }

    public function testTableStructure()
    {
        $structure = array(
            'admin/user' => array(),
            'helpdesk/attachment' => array(
                'attachment_id' => 'int(11)',
                'email_id' => 'int(11)',
                'message_id' => 'int(11)',
                'name' => 'varchar(255)',
                'type' => 'varchar(255)',
                'size' => 'int(11)',
                'body' => 'longblob',
                'external_id' => 'varchar(255)',
                'storage' => 'varchar(255)',
            ),
            'helpdesk/department' => array(
                'department_id' => 'int(11)',
                'name' => 'varchar(255)',
                'sender_email' => 'varchar(255)',
                'is_active' => 'tinyint(1)',
                'signature' => 'text',
                'sort_order' => 'smallint(5)',
                'is_notification_enabled' => 'tinyint(1)',
                'notification_email' => 'varchar(255)',
                'is_members_notification_enabled' => 'tinyint(1)',
            ),
            'helpdesk/department_user' => array(
                'department_user_id' => 'int(11)',
                'du_department_id' => 'int(11)',
                'du_user_id' => 'int(10) unsigned',
            ),
            'helpdesk/draft' => array(
                'draft_id' => 'int(11)',
                'ticket_id' => 'int(11)',
                'users_online' => 'varchar(255)',
                'body' => 'text',
                'updated_by' => 'int(11)',
                'updated_at' => 'timestamp',
            ),
            'helpdesk/email' => array(
                'email_id' => 'int(11)',
                'from_email' => 'varchar(255)',
                'to_email' => 'varchar(255)',
                'subject' => 'text',
                'body' => 'text',
                'format' => 'varchar(255)',
                'sender_name' => 'varchar(255)',
                'message_id' => 'varchar(255)',
                'pattern_id' => 'int(11)',
                'gateway_id' => 'int(11)',
                'headers' => 'text',
                'created_at' => 'timestamp',
                'is_processed' => 'tinyint(1)',
                'cc' => 'text',
                'bcc' => 'text',
            ),
            'helpdesk/field' => array(
                'field_id' => 'int(11)',
                'name' => 'varchar(255)',
                'code' => 'varchar(255)',
                'type' => 'varchar(255)',
                'values' => 'text',
                'description' => 'text',
                'is_active' => 'tinyint(1)',
                'sort_order' => 'smallint(5)',
                'is_required_staff' => 'tinyint(1)',
                'is_required_customer' => 'tinyint(1)',
                'is_visible_customer' => 'tinyint(1)',
                'is_editable_customer' => 'tinyint(1)',
                'is_visible_contact_form' => 'tinyint(1)',
            ),
            'helpdesk/field_store' => array(
                'field_store_id' => 'int(11)',
                'fs_field_id' => 'int(11)',
                'fs_store_id' => 'smallint(5) unsigned',
            ),
            'helpdesk/gateway' => array(
                'gateway_id' => 'int(11)',
                'name' => 'varchar(255)',
                'email' => 'varchar(255)',
                'login' => 'varchar(255)',
                'password' => 'varchar(255)',
                'is_active' => 'tinyint(1)',
                'host' => 'varchar(255)',
                'port' => 'int(11)',
                'protocol' => 'varchar(255)',
                'encryption' => 'varchar(255)',
                'fetch_frequency' => 'int(11)',
                'fetch_max' => 'int(11)',
                'department_id' => 'int(11)',
                'store_id' => 'smallint(5) unsigned',
                'notes' => 'text',
                'fetched_at' => 'timestamp',
                'last_fetch_result' => 'text',
                'fetch_limit' => 'int(11)',
                'is_delete_emails' => 'tinyint(1)',
            ),
            'helpdesk/history' => array(
                'history_id' => 'int(11)',
                'ticket_id' => 'int(11)',
                'triggered_by' => 'varchar(255)',
                'name' => 'varchar(255)',
                'message' => 'varchar(255)',
                'created_at' => 'timestamp',
            ),
            'helpdesk/message' => array(
                'message_id' => 'int(11)',
                'ticket_id' => 'int(11)',
                'email_id' => 'int(11)',
                'user_id' => 'int(11)',
                'customer_id' => 'int(11)',
                'customer_email' => 'varchar(255)',
                'customer_name' => 'varchar(255)',
                'body' => 'text',
                'body_format' => 'varchar(255)',
                'is_internal' => 'tinyint(1)',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
                'uid' => 'varchar(255)',
                'type' => 'varchar(255)',
                'third_party_email' => 'varchar(255)',
                'third_party_name' => 'varchar(255)',
                'triggered_by' => 'varchar(255)',
                'is_read' => 'tinyint(1)',
            ),
            'helpdesk/pattern' => array(
                'pattern_id' => 'int(11)',
                'name' => 'varchar(255)',
                'pattern' => 'text',
                'scope' => 'varchar(255)',
                'is_active' => 'tinyint(1)',
            ),
            'helpdesk/permission' => array(
                'permission_id' => 'int(11)',
                'role_id' => 'int(10) unsigned',
                'is_ticket_remove_allowed' => 'tinyint(1)',
            ),
            'helpdesk/permission_department' => array(
                'permission_department_id' => 'int(11)',
                'permission_id' => 'int(11)',
                'department_id' => 'int(11)',
            ),
            'helpdesk/priority' => array(
                'priority_id' => 'int(11)',
                'name' => 'varchar(255)',
                'sort_order' => 'smallint(5)',
                'color' => 'varchar(255)',
            ),
            'helpdesk/rule' => array(
                'rule_id' => 'int(11)',
                'name' => 'varchar(255)',
                'event' => 'varchar(255)',
                'email_subject' => 'varchar(255)',
                'email_body' => 'text',
                'is_active' => 'int(11)',
                'conditions_serialized' => 'text',
                'is_send_owner' => 'tinyint(1)',
                'is_send_department' => 'tinyint(1)',
                'is_send_user' => 'tinyint(1)',
                'other_email' => 'varchar(255)',
                'sort_order' => 'smallint(5)',
                'is_stop_processing' => 'tinyint(1)',
                'priority_id' => 'int(11)',
                'status_id' => 'int(11)',
                'department_id' => 'int(11)',
                'add_tags' => 'varchar(255)',
                'remove_tags' => 'varchar(255)',
                'is_archive' => 'tinyint(1)',
                'user_id' => 'int(10) unsigned',
                'is_send_attachment' => 'tinyint(1)',
            ),
            'helpdesk/satisfaction' => array(
                'satisfaction_id' => 'int(11)',
                'ticket_id' => 'int(11)',
                'message_id' => 'int(11)',
                'user_id' => 'int(10) unsigned',
                'customer_id' => 'int(10) unsigned',
                'store_id' => 'smallint(5) unsigned',
                'rate' => 'int(11)',
                'comment' => 'text',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ),
            'helpdesk/status' => array(
                'status_id' => 'int(11)',
                'name' => 'varchar(255)',
                'code' => 'varchar(255)',
                'sort_order' => 'smallint(5)',
                'color' => 'varchar(255)',
            ),
            'helpdesk/tag' => array(
                'tag_id' => 'int(11)',
                'name' => 'varchar(255)',
            ),
            'helpdesk/template' => array(
                'template_id' => 'int(11)',
                'name' => 'varchar(255)',
                'template' => 'text',
                'is_active' => 'tinyint(1)',
            ),
            'helpdesk/template_store' => array(
                'template_store_id' => 'int(11)',
                'ts_template_id' => 'int(11)',
                'ts_store_id' => 'smallint(5) unsigned',
            ),
            'helpdesk/ticket' => array(
                'ticket_id' => 'int(11)',
                'code' => 'varchar(255)',
                'external_id' => 'varchar(255)',
                'user_id' => 'int(11)',
                'name' => 'varchar(255)',
                'description' => 'text',
                'priority_id' => 'int(11)',
                'status_id' => 'int(11)',
                'department_id' => 'int(11)',
                'customer_id' => 'int(11)',
                'quote_address_id' => 'int(11)',
                'customer_email' => 'varchar(255)',
                'customer_name' => 'varchar(255)',
                'order_id' => 'int(11)',
                'last_reply_name' => 'varchar(255)',
                'last_reply_at' => 'timestamp',
                'reply_cnt' => 'int(11)',
                'store_id' => 'smallint(5) unsigned',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
                'is_spam' => 'tinyint(1)',
                'email_id' => 'int(11)',
                'first_reply_at' => 'timestamp',
                'first_solved_at' => 'timestamp',
                'is_archived' => 'tinyint(1)',
                'fp_period_unit' => 'varchar(255)',
                'fp_period_value' => 'int(11)',
                'fp_execute_at' => 'timestamp',
                'fp_is_remind' => 'tinyint(1)',
                'fp_remind_email' => 'varchar(255)',
                'fp_priority_id' => 'int(11)',
                'fp_status_id' => 'int(11)',
                'fp_department_id' => 'int(11)',
                'fp_user_id' => 'int(10) unsigned',
                'channel' => 'varchar(255)',
                'channel_data' => 'text',
                'third_party_email' => 'varchar(255)',
                'search_index' => 'text',
                'cc' => 'text',
                'bcc' => 'text',
                'merged_ticket_id' => 'int(11)',
            ),
            'helpdesk/ticket_aggregated_day' => array(
                'period' => 'datetime',
                'store_id' => 'smallint(5)',
                'user_id' => 'int(11)',
                'new_ticket_cnt' => 'int(11)',
                'solved_ticket_cnt' => 'int(11)',
                'changed_ticket_cnt' => 'int(11)',
                'total_reply_cnt' => 'int(11)',
                'first_reply_time' => 'int(11)',
                'first_resolution_time' => 'int(11)',
                'full_resolution_time' => 'int(11)',
                'satisfaction_rate_1_cnt' => 'int(11)',
                'satisfaction_rate_2_cnt' => 'int(11)',
                'satisfaction_rate_3_cnt' => 'int(11)',
                'satisfaction_rate' => 'int(11)',
                'satisfaction_response_cnt' => 'int(11)',
                'satisfaction_response_rate' => 'int(11)',
            ),
            'helpdesk/ticket_aggregated_hour' => array(
                'period' => 'datetime',
                'store_id' => 'smallint(5)',
                'user_id' => 'int(11)',
                'new_ticket_cnt' => 'int(11)',
                'solved_ticket_cnt' => 'int(11)',
                'changed_ticket_cnt' => 'int(11)',
                'total_reply_cnt' => 'int(11)',
                'first_reply_time' => 'int(11)',
                'first_resolution_time' => 'int(11)',
                'full_resolution_time' => 'int(11)',
                'satisfaction_rate_1_cnt' => 'int(11)',
                'satisfaction_rate_2_cnt' => 'int(11)',
                'satisfaction_rate_3_cnt' => 'int(11)',
                'satisfaction_rate' => 'int(11)',
                'satisfaction_response_cnt' => 'int(11)',
                'satisfaction_response_rate' => 'int(11)',
            ),
            'helpdesk/ticket_aggregated_month' => array(
                'period' => 'datetime',
                'store_id' => 'smallint(5)',
                'user_id' => 'int(11)',
                'new_ticket_cnt' => 'int(11)',
                'solved_ticket_cnt' => 'int(11)',
                'changed_ticket_cnt' => 'int(11)',
                'total_reply_cnt' => 'int(11)',
                'first_reply_time' => 'int(11)',
                'first_resolution_time' => 'int(11)',
                'full_resolution_time' => 'int(11)',
                'satisfaction_rate_1_cnt' => 'int(11)',
                'satisfaction_rate_2_cnt' => 'int(11)',
                'satisfaction_rate_3_cnt' => 'int(11)',
                'satisfaction_rate' => 'int(11)',
                'satisfaction_response_cnt' => 'int(11)',
                'satisfaction_response_rate' => 'int(11)',
            ),
            'helpdesk/ticket_tag' => array(
                'ticket_tag_id' => 'int(11)',
                'tt_ticket_id' => 'int(11)',
                'tt_tag_id' => 'int(11)',
            ),
            'helpdesk/user' => array(
                'user_id' => 'int(10) unsigned',
                'signature' => 'text',
            ),
        );

        $dbCheck = $this->dbCheckTables(array_keys($structure));
        if ($dbCheck[0] != self::SUCCESS) {
            return array(self::FAILED, 'HDMX Database Structure', $dbCheck[2]);
        }

        $title = 'HDMX Database Structure';
        $description = array();
        foreach (array_keys($structure) as $tableName) {
            // Pass 0: If table record has empty array - check is not performed
            if (!count($structure[$tableName])) {
                continue;
            }

            // Pass 1: Check for missing fields (sqlResult can not be reset for some reason)
            foreach (array_keys($structure[$tableName]) as $field) {
                $exists = false;
                $sqlResult = $this->_dbConn()->query('DESCRIBE '.$this->_dbRes()->getTableName($tableName).';');
                foreach ($sqlResult as $sqlRow) {
                    if (!$exists && $sqlRow['Field'] == $field) {
                        $exists = true;
                    }
                }
                if (!$exists) {
                    $description[] = $this->_dbRes()->getTableName($tableName).' has missing field: '.$field;
                }
            }

            // Pass 2: Check for types and alteration
            $sqlResult = $this->_dbConn()->query('DESCRIBE '.$this->_dbRes()->getTableName($tableName).';');
            foreach ($sqlResult as $sqlRow) {
                if (array_key_exists($sqlRow['Field'], $structure[$tableName])) {
                    if ($sqlRow['Type'] != $structure[$tableName][$sqlRow['Field']]) {
                        $description[] = $this->_dbRes()->getTableName($tableName).' has different structure, field '.$sqlRow['Field'].' has type '.$sqlRow['Type'];
                    }
                } else {
                    $description[] = $this->_dbRes()->getTableName($tableName).' was altered and has custom field '.$sqlRow['Field'];
                }
            }
        }

        return (count($description)) ?
            array(self::FAILED, $title, array_merge($description, array('Contact Mirasvit Support.'))) :
            array(self::SUCCESS, $title, $description);
    }
}
