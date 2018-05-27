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

use DrewM\MailChimp\MailChimp as MailChimpClient;

/**
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class Commerce extends Component
{
    /**
     * @var MailChimpClient
     */
    private $client;

    public function init()
    {
        parent::init();

        $this->client = $this->_getClient();
    }

    public function onAddToCart($email = null, $data = [])
    {
        $hash = $this->client->subscriberHash($email);
        $this->client->post();
    }

    // Public Methods
    // =========================================================================

    private
    function _getClient()
    {
        $settings = MailChimp::$plugin->getSettings();
        $client   = new MailChimpClient($settings->getApiKey());

        return $client;
    }

    /**
     * @return mixed
     */
    private
    function _getDefaultListId()
    {
        return MailChimp::$plugin->getSettings()->defaultListId;
    }
}
