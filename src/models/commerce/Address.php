<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp\models\commerce;

use superbig\mailchimp\MailChimp;

use Craft;
use craft\base\Model;

/**
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class Address extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * The name associated with an order’s shipping address.
     *
     * @var string
     */
    public $name;

    /**
     * The mailing address of the customer.
     *
     * @var string
     */
    public $address1;

    /**
     * An additional field for the customer’s mailing address.
     *
     * @var string
     */
    public $address2;

    /**
     * The city the customer is located in.
     *
     * @var string
     */
    public $city;

    /**
     * The customer’s state name or normalized province.
     *
     * @var string
     */
    public $province;

    /**
     * The two-letter code for the customer’s province or state.
     *
     * @var string
     */
    public $province_code;

    /**
     * The customer’s postal or zip code.
     *
     * @var string
     */
    public $postal_code;

    /**
     * The customer’s country.
     *
     * @var string
     */
    public $country;

    /**
     * The two-letter code for the customer’s country.
     *
     * @var string
     */
    public $country_code;

    /**
     * The phone number for the order’s shipping address.
     *
     * @var string
     */
    public $phone;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [ 'someAttribute', 'string' ],
            [ 'someAttribute', 'default', 'value' => 'Some Default' ],
        ];
    }
}
