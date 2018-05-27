<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp\models;

use superbig\mailchimp\MailChimp;

use Craft;
use craft\base\Model;

/**
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $apiKey = '';

    /**
     * @var string
     */
    public $defaultListId = '';

    /**
     * @var bool
     */
    public $dbAsSourceOfTruth = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['apiKey', 'string'],
            ['defaultListId', 'default', 'value' => ''],
        ];
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }
}
