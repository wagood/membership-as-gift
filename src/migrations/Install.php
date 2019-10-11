<?php
/**
 * membership-as-gift plugin for Craft CMS 3.x
 *
 * Purchase membership as gift
 *
 * @link      https://prestaclub.ru
 * @copyright Copyright (c) 2019 WAGOOD
 */

namespace wagood\membershipasgift\migrations;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;
use craft\helpers\MigrationHelper;

/**
 * membership-as-gift Install Migration
 *
 * If your plugin needs to create any custom database tables when it gets installed,
 * create a migrations/ folder within your plugin folder, and save an Install.php file
 * within it using the following template:
 *
 * If you need to perform any additional actions on install/uninstall, override the
 * safeUp() and safeDown() methods.
 *
 * @author    WAGOOD
 * @package   Membershipasgift
 * @since     0.0.1
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
   * This method contains the logic to be executed when applying this migration.
   * This method differs from [[up()]] in that the DB logic implemented here will
   * be enclosed within a DB transaction.
   * Child classes may implement this method instead of [[up()]] if the DB logic
   * needs to be within a transaction.
   *
   * @return boolean return a false value to indicate the migration fails
   * and should not proceed further. All other return values mean the migration succeeds.
   */
  public function safeUp()
  {
    $this->driver = Craft::$app->getConfig()->getDb()->driver;
    if ($this->createTables()) {
      $this->createIndexes();
      // Refresh the db schema caches
      Craft::$app->db->schema->refresh();
      $this->addForeignKeys();
      $this->insertDefaultData();
    }

    return true;
  }

  /**
   * This method contains the logic to be executed when removing this migration.
   * This method differs from [[down()]] in that the DB logic implemented here will
   * be enclosed within a DB transaction.
   * Child classes may implement this method instead of [[down()]] if the DB logic
   * needs to be within a transaction.
   *
   * @return boolean return a false value to indicate the migration fails
   * and should not proceed further. All other return values mean the migration succeeds.
   */
  public function safeDown()
  {
    $this->driver = Craft::$app->getConfig()->getDb()->driver;
    $this->dropForeignKeys();
    $this->removeTables();

    return true;
  }

  // Protected Methods
  // =========================================================================

  /**
   * Creates the tables needed for the Records used by the plugin
   *
   * @return bool
   */
  protected function createTables()
  {
    $tablesCreated = false;

    // membershipasgift_giftrecord table
    $tableSchema = Craft::$app->db->schema->getTableSchema('{{%membershipasgift_giftrecord}}');
    if ($tableSchema === null) {
      $tablesCreated = true;
      $this->createTable(
          '{{%membershipasgift_giftrecord}}',
          [
              'id' => $this->primaryKey(),
              'dateCreated' => $this->dateTime()->notNull(),
              'dateUpdated' => $this->dateTime()->notNull(),
              'uid' => $this->uid(),
            // Custom columns in the table
              'giftCode' => $this->string(32)->notNull()->defaultValue(''),
              'subscriptionId' => $this->integer()->notNull()->defaultValue(0),
              'subscriptionType' => $this->string(32)->notNull()->defaultValue(''),
          ]
      );
    }

    return $tablesCreated;
  }

    protected function addForeignKeys()
    {
        $this->addForeignKey($this->db->getForeignKeyName('{{%membershipasgift_giftrecord}}', 'id'), '{{%membershipasgift_giftrecord}}', 'id', '{{%elements}}', 'id', 'CASCADE', null);
    }

    protected function dropForeignKeys()
    {
        MigrationHelper::dropAllForeignKeysOnTable('{{%membershipasgift_giftrecord}}', $this);
    }
  /**
   * Creates the indexes needed for the Records used by the plugin
   *
   * @return void
   */
  protected function createIndexes()
  {
    // membershipasgift_giftrecord table
    $this->createIndex(
        $this->db->getIndexName(
            '{{%membershipasgift_giftrecord}}',
            'giftCode',
            true
        ),
        '{{%membershipasgift_giftrecord}}',
        'giftCode',
        true
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
   * Populates the DB with the default data.
   *
   * @return void
   */
  protected function insertDefaultData()
  {
  }

  /**
   * Removes the tables needed for the Records used by the plugin
   *
   * @return void
   */
  protected function removeTables()
  {
    // membershipasgift_giftrecord table
    $this->dropTableIfExists('{{%membershipasgift_giftrecord}}');
  }
}
