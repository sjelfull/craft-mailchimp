<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp\console\controllers;

use superbig\mailchimp\MailChimp;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Default Command
 *
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class DefaultController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Handle mailchimp/default console commands
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'something';

        echo "Welcome to the console DefaultController actionIndex() method\n";

        return $result;
    }

    /**
     * Handle mailchimp/default/do-something console commands
     *
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'something';

        echo "Welcome to the console DefaultController actionDoSomething() method\n";

        return $result;
    }
}
