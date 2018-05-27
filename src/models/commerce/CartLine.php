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
class CartLine extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * A unique identifier for the cart line item.
     *
     * @var integer
     */
    public $id;

    /**
     * A unique identifier for the product associated with the cart line item.
     *
     * @var integer
     */
    public $product_id;

    /**
     * A unique identifier for the product variant associated with the cart line item.
     *
     * @var integer
     */
    public $product_variant_id;

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
