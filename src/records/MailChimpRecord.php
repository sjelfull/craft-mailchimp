<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp\records;

use superbig\mailchimp\MailChimp;

use Craft;
use craft\db\ActiveRecord;

/**
 * MailChimp Subscriber record
 *
 * @property int       $id             ID
 * @property int|null  $userId         User ID
 * @property int       $siteId         Site ID
 * @property string    $email          Email
 * @property string    $listId         MailChimp List ID
 * @property \DateTime $dateCreated    Create date
 * @property \DateTime $dateUpdated    Update date
 *
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class MailChimpRecord extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName ()
    {
        return '{{%mailchimp_subscribers}}';
    }
}
