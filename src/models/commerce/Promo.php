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
class Promo extends Model
{
    // https://developer.mailchimp.com/documentation/mailchimp/reference/ecommerce/stores/promo-rules/

    // Public Properties
    // =========================================================================

    /**
     * The Promo Code
     *
     * @var integer
     */
    public $code;

    /**
     * 	The amount of discount applied on the total price. For example if the total cost was $100 and the customer paid $95.5, amount_discounted will be 4.5 For free shipping set amount_discounted to 0
     *
     * @var float
     */
    public $amount_discounted;

    /**
     * A unique identifier for the product variant associated with the cart line item.
     *
     * @var string
     */
    public $type;

    /**
     * The quantity of a cart line item.
     *
     * @var integer
     */
    public $quantity = 0;


    /**
     * The price of a cart line item.
     *
     * @var float
     */
    public $price = 0;

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
