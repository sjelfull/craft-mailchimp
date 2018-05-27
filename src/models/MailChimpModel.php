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
class MailChimpModel extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $email = '';

    /**
     * @var string
     */
    public $firstName = '';

    /**
     * @var string
     */
    public $lastName = '';

    /**
     * @var array
     */
    public $mergeFields = [];

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [ 'email', 'required' ],
            [ 'email', 'email' ],
        ];
    }
}
