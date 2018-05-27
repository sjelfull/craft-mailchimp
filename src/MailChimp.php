<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp;

use craft\elements\User;
use craft\events\ElementEvent;
use craft\services\Elements;
use superbig\mailchimp\fields\MailChimpField;
use superbig\mailchimp\services\MailChimpService as MailChimpServiceService;
use superbig\mailchimp\services\Lists as ListsService;
use superbig\mailchimp\services\Subscriber as SubscriberService;
use superbig\mailchimp\variables\MailChimpVariable;
use superbig\mailchimp\models\Settings;
use superbig\mailchimp\widgets\MailChimpWidget as MailChimpWidgetWidget;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\console\Application as ConsoleApplication;
use craft\web\UrlManager;
use craft\services\Fields;
use craft\web\twig\variables\CraftVariable;
use craft\services\Dashboard;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;
use yii\base\ModelEvent;

/**
 * Class MailChimp
 *
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 *
 * @property  MailChimpServiceService $mailChimpService
 * @property  ListsService            $lists
 * @property  SubscriberService       $subscriber
 * @method  Settings       getSettings()
 */
class MailChimp extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var MailChimp
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'superbig\mailchimp\console\controllers';
        }

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['mailchimp/subscribe']   = 'mailchimp/default/subscribe';
                $event->rules['mailchimp/unsubscribe'] = 'mailchimp/deafult/unsubscribe';
            }
        );

        /*Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['cpActionTrigger1'] = 'mailchimp/default/do-something';
            }
        );*/

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = MailChimpField::class;
            }
        );

        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = MailChimpWidgetWidget::class;
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('mailChimp', MailChimpVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Event::on(
            Elements::class,
            Elements::EVENT_AFTER_SAVE_ELEMENT,
            function (ElementEvent $event) {
                if ($event->element instanceof User) {
                    $this->mailChimpService->onSaveUser($event->element);
                }
            }
        );

        Craft::info(
            Craft::t(
                'mailchimp',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'mailchimp/settings',
            [
                'settings' => $this->getSettings(),
            ]
        );
    }
}
