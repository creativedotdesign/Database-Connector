<?php
/**
 * Lambda Creatives
 * Database connection class
 */
namespace Lambda\Database;

use Mysqli;

abstract class Connector {
  protected static $connection = null;
  private $settings;

  // Disconnect from database
  public static function disconnect() {
    self::$connection->close();
    self::$connection = null;
  }

  // Check if already connected
  public static function isConnected() {
    if (self::getInstance()) {
      $get_test   = self::getInstance()->query("SELECT 1 AS test");
      $connection = (boolean) $get_test->num_rows;
    } else {
      $connection = false;
    }
    return $connection;
  }

  public static function connect(array $connection_settings = array())  {
    if ($connection_settings) {
      $settings = $connection_settings;
    } else {
      throw new \Lambda\Database\BetterException('Failed to get settings.');
    }

    try {
      $mysqli = new mysqli($settings['host'], $settings['username'], $settings['password'], $settings['database']);
      self::$connection = $mysqli;
    } catch (Exception $e) {
      throw new \Lambda\Database\BetterException($e->getMessage());
      self::$connection = false;
    }
  }

  public static function getInstance() {
    return self::$connection;
  }
}
