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



// namespace Mirasvit_Ddeboer\Imap\Search\Date;

// use Mirasvit_Ddeboer\Imap\Search\Date;
// use Mirasvit_Ddeboer\Imap\Search\Condition;

// use DateTime;

/**
 * Represents a date before condition. Messages must have a date before the
 * specified date in order to match the condition.
 */
class Mirasvit_Ddeboer_Imap_Search_Date_Before extends Mirasvit_Ddeboer_Imap_Search_Date
{
    /**
     * Returns the keyword that the condition represents.
     *
     * @return string
     */
    public function getKeyword()
    {
        return 'BEFORE';
    }
}