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
class Order extends Cart
{
    // https://developer.mailchimp.com/documentation/mailchimp/reference/ecommerce/orders/

    // Public Properties
    // =========================================================================

    /**
     * The URL for the page where the buyer landed when entering the shop.
     *
     * @var string
     */
    public $landing_site;


    /**
     * The order status. Use this parameter to trigger Order Notifications.
     *
     * @var string
     */
    public $financial_status;

    /**
     * The fulfillment status for the order. Use this parameter to trigger Order Notifications.
     *
     * @var string
     */
    public $fulfillment_status;

    /**
     * The URL for the order.
     *
     * @var string
     */
    public $order_url;

    /**
     * The total amount of the discounts to be applied to the price of the order.
     *
     * @var float
     */
    public $discount_total;

    /**
     * The shipping total for the order.
     *
     * @var float
     */
    public $shipping_total;

    /**
     * The MailChimp tracking code for the order. Uses the ‘mc_tc’ parameter in E-Commerce tracking URLs.
     *
     * @var string
     */
    public $tracking_code;

    /**
     * The date and time the order was processed.
     *
     * @var string
     */
    public $processed_at_foreign;

    /**
     * The date and time the order was cancelled.
     *
     * @var string
     */
    public $cancelled_at_foreign;

    /**
     * The date and time the order was updated.
     *
     * @var string
     */
    public $updated_at_foreign;

    /**
     * The shipping address for the order.
     *
     * @var Address
     */
    public $shipping_address;

    /**
     * The billing address for the order.
     *
     * @var Address
     */
    public $billing_address;

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
