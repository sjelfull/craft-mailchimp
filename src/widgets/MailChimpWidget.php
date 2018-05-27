<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp\widgets;

use superbig\mailchimp\MailChimp;
use superbig\mailchimp\assetbundles\mailchimpwidgetwidget\MailChimpWidgetWidgetAsset;

use Craft;
use craft\base\Widget;

/**
 * MailChimp Widget
 *
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class MailChimpWidget extends Widget
{

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $message = 'Hello, world.';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('mailchimp', 'MailChimpWidget');
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias("@superbig/mailchimp/assetbundles/mailchimpwidgetwidget/dist/img/MailChimpWidget-icon.svg");
    }

    /**
     * @inheritdoc
     */
    public static function maxColspan()
    {
        return null;
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge(
            $rules,
            [
                ['message', 'string'],
                ['message', 'default', 'value' => 'Hello, world.'],
            ]
        );
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'mailchimp/_components/widgets/MailChimpWidget_settings',
            [
                'widget' => $this
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getBodyHtml()
    {
        Craft::$app->getView()->registerAssetBundle(MailChimpWidgetWidgetAsset::class);

        return Craft::$app->getView()->renderTemplate(
            'mailchimp/_components/widgets/MailChimpWidget_body',
            [
                'message' => $this->message
            ]
        );
    }
}
