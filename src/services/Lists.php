<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp\services;

use superbig\mailchimp\MailChimp;

use Craft;
use craft\base\Component;

/**
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class Lists extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (MailChimp::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
