<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp\controllers;

use Craft;
use superbig\mailchimp\MailChimp;

use craft\web\Controller;
use \DrewM\MailChimp\Webhook;
use superbig\mailchimp\models\MailChimpModel;

/**
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = [ 'index', 'webhook', 'subscribe', 'unsubscribe' ];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex ()
    {
        $result = 'Welcome to the DefaultController actionIndex() method';

        return $result;
    }

    /**
     * @return mixed
     */
    public function actionWebhook ()
    {
        Webhook::subscribe('unsubscribe', function ($data) {
            print_r($data);
        });

        //Webhook::receive();

        return $result;
    }

    public function actionSubscribe ()
    {
        $request     = Craft::$app->request;
        $email       = $request->getRequiredParam('email');
        $firstName   = $request->getParam('firstName');
        $lastName    = $request->getParam('lastName');
        $mergeFields = $request->getParam('mergeFields', []);
        $listId      = $request->getParam('listId');

        $model = new MailChimpModel([
            'email'       => $email,
            'firstName'   => $firstName,
            'lastName'    => $lastName,
            'mergeFields' => $mergeFields,
        ]);

        $errors    = null;
        $subscribe = MailChimp::$plugin->mailChimpService->subscribe($model, $listId);

        if ( !$subscribe ) {
            return $this->_errorResponse($model);
        }

        return $this->_successResponse($model);


    }

    private function _errorResponse (MailChimpModel $model)
    {
        if ( Craft::$app->request->getAcceptsJson() ) {
            return $this->asJson([
                'success' => false,
                'errors'  => $model->getErrors(),
            ]);
        }

        Craft::$app->session->setError(Craft::t('mailchimp', 'There was a problem with your submission. Please check your details and try again.'));
        Craft::$app->urlManager->setRouteParams([ 'variables' => [ 'mailchimp' => $model ] ]);

        return null;
    }

    private function _successResponse (MailChimpModel $model)
    {
        if ( Craft::$app->request->getAcceptsJson() ) {
            return $this->asJson([ 'success' => true ]);
        }

        //Craft::$app->getSession()->setNotice($settings->successFlashMessage);

        return $this->redirectToPostedUrl($model);
    }
}
