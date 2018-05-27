<?php
/**
 * MailChimp plugin for Craft CMS 3.x
 *
 * MailChimp
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\mailchimp\migrations;

use superbig\mailchimp\MailChimp;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * @author    Superbig
 * @package   MailChimp
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp ()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ( $this->createTables() ) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown ()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables ()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%mailchimp_subscribers}}');
        if ( $tableSchema === null ) {
            $tablesCreated = true;
            $this->createTable(
                '{{%mailchimp_subscribers}}',
                [
                    'id'          => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid'         => $this->uid(),
                    'siteId'      => $this->integer()->notNull(),
                    'userId'      => $this->integer()->null(),
                    'listId'      => $this->string(255)->notNull(),
                    'email'       => $this->string(255)->notNull(),
                    'status'      => $this->enum('status', [ 'subscribed', 'unsubscribed' ])->notNull()->defaultValue('subscribed'),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes ()
    {
        $this->createIndex(
            $this->db->getIndexName(
                '{{%mailchimp_subscribers}}',
                'userId',
                false
            ),
            '{{%mailchimp_subscribers}}',
            'userId',
            false
        );

        $this->createIndex(
            $this->db->getIndexName(
                '{{%mailchimp_subscribers}}',
                'listId',
                false
            ),
            '{{%mailchimp_subscribers}}',
            'listId',
            false
        );

        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * @return void
     */
    protected function addForeignKeys ()
    {
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%mailchimp_subscribers}}', 'siteId'),
            '{{%mailchimp_subscribers}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%mailchimp_subscribers}}', 'userId'),
            '{{%mailchimp_subscribers}}',
            'userId',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @return void
     */
    protected function insertDefaultData ()
    {
    }

    /**
     * @return void
     */
    protected function removeTables ()
    {
        $this->dropTableIfExists('{{%mailchimp_subscribers}}');
    }
}
