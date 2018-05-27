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
class Cart extends Model
{
    // https://developer.mailchimp.com/documentation/mailchimp/reference/ecommerce/stores/carts/#

    // Public Properties
    // =========================================================================

    /**
     * A unique identifier for the cart.
     *
     * @var integer
     */
    public $id;

    /**
     * Information about a specific customer. Carts for existing customers should include only the id parameter in the
     * customer object body.
     *
     * @var Customer
     */
    public $customer;

    /**
     * A string that uniquely identifies the campaign for a cart.
     *
     * @var string
     */
    public $campaign_id;

    /**
     * The URL for the cart. This parameter is required for Abandoned Cart automations.
     *
     * @var string
     */
    public $checkout_url;

    /**
     * The three-letter ISO 4217 code for the currency that the cart uses.
     *
     * @var string
     */
    public $currency_code;

    /**
     * The order total for the cart.
     *
     * @var float
     */
    public $order_total = 0;

    /**
     * The total tax for the cart.
     *
     * @var float
     */
    public $tax_total = 0;


    /**
     * An array of the cart’s line items.
     *
     * @var CartLine[]
     */
    public $lines;

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

    public function setLinesFromOrder ($order = null)
    {
        $lines = [];

        foreach ($order->getCartContents() as $orderLine) {
            $line             = new CartLine();
            $line->id         = $orderLine->id;
            $line->product_id = $orderLine->product_id;
        }

        $this->lines = $lines;
    }
}
