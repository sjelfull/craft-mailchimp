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
class MailChimpFieldCopy extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $someAttribute = 'Some Default';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName (): string
    {
        return Craft::t('mailchimp', 'MailChimp Subscribe');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            [ 'subscribe', 'default', 'value' => false ],
        ]);

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType (): string
    {
        return Schema::TYPE_BOOLEAN;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue ($value, ElementInterface $element = null)
    {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue ($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml ()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'mailchimp/_components/fields/_settings',
            [
                'field' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml ($value, ElementInterface $element = null): string
    {
        // Register our asset bundle
        Craft::$app->getView()->registerAssetBundle(FieldAsset::class);

        // Get our id and namespace
        $id           = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id'        => $id,
            'name'      => $this->handle,
            'namespace' => $namespacedId,
            'prefix'    => Craft::$app->getView()->namespaceInputId(''),
        ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').MailChimp(" . $jsonVars . ");");

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'mailchimp/_components/fields/_input',
            [
                'name'         => $this->handle,
                'value'        => $value,
                'field'        => $this,
                'id'           => $id,
                'namespacedId' => $namespacedId,
            ]
        );
    }
}
