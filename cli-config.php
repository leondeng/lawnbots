<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Fan\Lawnbots\DBAL\ConnectionsManager;

require_once 'bootstrap.php';

$entityManager = ConnectionsManager::GetEntityManager('doctrine');

return ConsoleRunner::createHelperSet($entityManager);