<?php
namespace Fan\Lawnbots\DBAL;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Configuration;
use Doctrine\Common\EventManager;
use Symfony\Component\Yaml\Yaml;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class ConnectionsManager
{
  private static $dbConfigs = array();


  public static function getDatabaseConfiguration($name) {
    if (isset(self::$dbConfigs[$name])) return self::$dbConfigs[$name];

    $libDir = dirname(dirname(dirname(dirname(__FILE__))));
    $baseDir = dirname($libDir);
    $directories = array($baseDir.'/config', $baseDir.'/../../../config');

    $dbConfigFile = null;
    foreach ($directories as $directory) {
      $dbConfigFile = $directory . DIRECTORY_SEPARATOR . 'databases.yml';
      if (file_exists($dbConfigFile)) {
        break;
      }
    }

    if ( ! file_exists($dbConfigFile)) {
      throw new \Doctrine\DBAL\DBALException(sprintf('Configuration file [%s] does not exist.', $dbConfigFile));
    }

    if ( ! is_readable($dbConfigFile)) {
      throw new \Doctrine\DBAL\DBALException(sprintf('Configuration file [%s] does not have read permission.', $dbConfigFile));
    }

    self::$dbConfigs = Yaml::parse($dbConfigFile);

    if ( ! isset(self::$dbConfigs[$name])) {
      throw new \Doctrine\DBAL\DBALException(sprintf('Missing %s database configuration!', $name));
    }

    return self::$dbConfigs[$name];
  }

  public static function GetEntityManager($conn) {
    $dbParams = self::getDatabaseConfiguration($conn);
    $isDevMode = true;
    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../../Entity"), $isDevMode, null, null, false);

    return  EntityManager::create($dbParams, $config);
  }
}