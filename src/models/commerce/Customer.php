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
class Customer extends Model
{
    // DOCS: https://developer.mailchimp.com/documentation/mailchimp/reference/ecommerce/stores/customers/

    // Public Properties
    // =========================================================================

    /**
     * A unique identifier for the customer.
     *
     * @var integer
     */
    public $id;


    /**
     * The customer’s email address
     *
     * @var string
     */
    public $email_address;

    /**
     * The customer’s opt-in status. This value will never overwrite the opt-in status of a pre-existing MailChimp list
     * member, but will apply to list members that are added through the e-commerce API endpoints. Customers who don’t
     * opt in to your MailChimp list will be added as Transactional members.
     *
     * @var bool
     */
    public $opt_in_status = false;

    /**
     * The customer’s company.
     *
     * @var string
     */
    public $company;

    /**
     * The customer’s first name.
     *
     * @var string
     */
    public $first_name;

    /**
     * The customer’s last name.
     *
     * @var string
     */
    public $last_name;

    /**
     * The customer’s total order count. Learn More about using this data.
     *
     * @var integer
     */
    public $orders_count = 0;

    /**
     * The total amount the customer has spent. Learn More about using this data.
     *
     * @var float
     */
    public $total_spent = 0;

    /**
     * The customer’s address.
     *
     * @var null|Address
     */
    public $address;

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
