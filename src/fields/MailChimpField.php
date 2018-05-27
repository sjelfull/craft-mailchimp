<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp\fields;

use craft\fields\Lightswitch;
use superbig\mailchimp\MailChimp;
use superbig\mailchimp\assetbundles\field\FieldAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class MailChimpField extends Lightswitch
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $listId = '';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName (): string
    {
        return Craft::t('mailchimp', 'MailChimp Subscribe');
    }

    public function getSettingsHtml ()
    {
        $html = [
            Craft::$app->getView()->renderTemplateMacro('_includes/forms', 'lightswitchField',
                [
                    [
                        'label' => Craft::t('app', 'Default Value'),
                        'id'    => 'default',
                        'name'  => 'default',
                        'on'    => $this->default,
                    ]
                ]),

            Craft::$app->getView()->renderTemplateMacro('_includes/forms', 'textField',
                [
                    [
                        'label'       => Craft::t('mailchimp', 'List ID'),
                        'description' => Craft::t('mailchimp', 'Will use default list id if nothing is supplied.'),
                        'id'          => 'listId',
                        'name'        => 'listId',
                        'value'       => $this->listId,
                    ]
                ]),
        ];

        return implode('', $html);
    }
}
