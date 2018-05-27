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

use craft\elements\User;
use superbig\mailchimp\fields\MailChimpField;
use superbig\mailchimp\MailChimp;

use Craft;
use craft\base\Component;
use superbig\mailchimp\models\MailChimpModel;
use superbig\mailchimp\records\MailChimpRecord;

use DrewM\MailChimp\MailChimp as MailChimpClient;

/**
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class MailChimpService extends Component
{
    // https://developer.mailchimp.com/documentation/mailchimp/guides/manage-subscribers-with-the-mailchimp-api/
    // https://developer.mailchimp.com/documentation/mailchimp/guides/getting-started-with-ecommerce/
    // https://kb.mailchimp.com/integrations/e-commerce/sell-more-stuff-with-mailchimp
    // https://developer.mailchimp.com/documentation/mailchimp/guides/mailchimp-api-best-practices/

    const SUBSCRIBED   = 'subscribed';
    const UNSUBSCRIBED = 'unsubscribed';

    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function onSaveUser (User $user)
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        /*
         * if (MailChimp::$plugin->getSettings()->someAttribute) {
        }
        */

        foreach ($user->getFieldLayout()->getFields() as $field) {
            if ( $field instanceof MailChimpField ) {
                $subscriber = $this->getSubscriberByEmail($user->email);
                $handle     = $field->handle;
                $isChecked  = $user->$handle;

                if ( $isChecked && !$subscriber ) {
                    $this->subscribeUser($user);
                }
                else {
                    $this->unsubscribeUser($user);
                }

                Craft::info(
                    Craft::t(
                        'mailchimp',
                        '{email} subscribe status: {status} checked: {check}',
                        [
                            'email'  => $user->email,
                            'status' => $subscriber ? 'is subscribed' : 'is not subscribed',
                            'check'  => $user->$handle ? 'on' : 'off',

                        ]
                    ),
                    __METHOD__
                );
            }
        }

        return $result;
    }

    public function subscribe (MailChimpModel &$model, $listId = null)
    {
        if ( !$model->validate() ) {
            return false;
        }

        if ( !$listId ) {
            $listId = $this->_getDefaultListId();
            $listId = null;
        }

        $record = MailChimpRecord::findOne([ 'email' => $model->email, 'listId' => $this->_getDefaultListId() ]);

        $client  = $this->getClient();
        $payload = [
            'email_address' => $model->email,
            'status'        => 'subscribed',
        ];

        if ( $model->firstName ) $model->mergeFields['FNAME'] = $model->firstName;
        if ( $model->lastName ) $model->mergeFields['LNAME'] = $model->lastName;

        if ( !empty($model->mergeFields) ) {
            $payload['merge_fields'] = $model->mergeFields;
        }

        if ( $record ) {
            return false;
            //$client->put("lists/$listId/members", $payload);
        }
        else {
            $client->post("lists/$listId/members", $payload);
        }

        if ( !$client->success() ) {
            $error = $this->_getErrorFromResponse($client->getLastResponse(), $client->getLastError());

            $model->addError('response', $error);

            return false;
        }

        if ( !$record ) {
            $record = new MailChimpRecord();
        }

        $record->email  = $model->email;
        $record->siteId = 1;
        $record->listId = $listId;
        $record->save();
    }

    public function subscribeUser (User $user, $listId = null)
    {
        $record = MailChimpRecord::findOne([ 'email' => $user->email, 'listId' => $this->_getDefaultListId() ]);

        if ( !$record ) {
            $record = new MailChimpRecord();
        }

        $client = $this->getClient();
        $client->post("lists/$listId/members", [
            'email_address' => $user->email,
            'status'        => 'subscribed',
            /*"merge_fields" => [
                "FNAME" => "Urist",
                "LNAME" => "McVankab"
            ]*/
        ]);

        $record->email  = $user->email;
        $record->siteId = 1;
        $record->userId = $user->id;
        $record->listId = $this->_getDefaultListId();
        $record->save();
    }

    public function unsubscribeUser (User $user, $listId = null)
    {
        // $user->email
    }

    public function getSubscriberByEmail ($email = null, $listId = null)
    {
        $defaultListId = $this->_getDefaultListId();

        if ( !$listId ) {
            $listId = $defaultListId;
        }

        $record = MailChimpRecord::findOne([ 'email' => $email, 'listId' => $listId ]);

        if ( !$record ) {
            return null;
        }

        return $record;
    }

    private function _getListInterestGroups ($listId = null)
    {
        $result  = [];
        $client  = $this->getClient();
        $request = $client->get("lists/$listId/interest-categories");

        if ( !$client->success() ) {
            $error = $this->_getErrorFromResponse($client->getLastResponse(), $client->getLastError());

            return $error;
        }

        return array_map(function ($category) use ($listId, $client) {
            // TODO: Error handling for this?
            $interests = $request = $client->get("lists/$listId/interest-categories/$category->id/interests");

            return [
                'title'     => $category->title,
                'type'      => $category->type,
                'interests' => array_map(function ($interest) {
                    return [
                        'id'   => $interest->id,
                        'name' => $interest->name,
                    ];
                }, $interests),
            ];
        }, $request['categories']);
    }

    public function hasSubscribed ($email, $listId = null)
    {
        // https://stackoverflow.com/questions/38569889/check-whether-email-is-subscribed-to-list-in-mailchimp-api-3-0-using-php
        return $this->getSubscriberByEmail($email, $listId);
    }

    public function getClient ()
    {
        $settings = MailChimp::$plugin->getSettings();
        $client   = new MailChimpClient($settings->getApiKey());

        return $client;
    }

    /**
     * @return mixed
     */
    private function _getDefaultListId ()
    {
        return MailChimp::$plugin->getSettings()->defaultListId;
    }

    private function _getErrorFromResponse ($response, $errorMessage)
    {
        $code    = $this->_findHTTPStatus($response);
        $message = $errorMessage;

        $error = [
            'success' => false,
            'code'    => $code,
            'message' => $message,
        ];

        // TODO: Add request data?
        Craft::error($error, 'mailchimp');

        return $error;
        // https://developer.mailchimp.com/documentation/mailchimp/guides/error-glossary/
        // Get status code
        // Use error messages
    }

    /**
     * Find the HTTP status code from the headers or API response body
     *
     * @param array       $response          The response from the curl request
     * @param array|false $formattedResponse The response body payload from the curl request
     *
     * @return int  HTTP status code
     */
    private function _findHTTPStatus ($response)
    {
        if ( !empty($response['headers']) && isset($response['headers']['http_code']) ) {
            return (int)$response['headers']['http_code'];
        }

        return 418;
    }
}
