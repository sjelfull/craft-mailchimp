<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp\assetbundles\indexcpsection;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class IndexCPSectionAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@superbig/mailchimp/assetbundles/indexcpsection/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/IndexRecord.js',
        ];

        $this->css = [
            'css/IndexRecord.css',
        ];

        parent::init();
    }
}
