<?php

use Fan\Lawnbots\Entity\Bot;

class BotTest extends \PHPUnit_Framework_TestCase
{

  public function testBotCreate() {
    $bot = $this->getBot();
    $this->assertInstanceOf(Bot, $bot);
  }

  public function getBot() {
    $bot = new Bot();
    $bot->setName('R2D2');

    return $bot;
  }
}