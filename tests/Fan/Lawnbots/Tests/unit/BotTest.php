<?php

namespace Fan\Lawnbots\Tests\unit;

use Fan\Lawnbots\Entity\Bot;

class BotTest extends \PHPUnit_Framework_TestCase
{

  public function testBotCreate() {
    $bot = $this->getBot();
    $this->assertInstanceOf('Fan\Lawnbots\Entity\Bot', $bot);
    $this->assertEquals(1, $bot->getX());
    $this->assertEquals(2, $bot->getY());
    $this->assertEquals('LMLMLMLMM', $bot->getCommand());
  }
  
  public function testBotCreateWrongPosition() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong position string!');
    $bot = Bot::create('11N', 'S62d8');
  }
  
  public function testBotCreateWrongCommand() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong command string!');
    $bot = Bot::create('2 3 S', 'sjfewpnfe21');
  }
  
  public function testBotCreateWrongXPostion() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong x position!');
    $bot = $this->getBot();
    $bot->setX('x');
  }
  
  public function testBotCreateWrongPostion() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong y position!');
    $bot = $this->getBot();
    $bot->setY('y');
  }
  
  public function testBotCreateWrongHeading() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong heading!');
    $bot = $this->getBot();
    $bot->setHeading('999');
  }

  public function getBot() {
    $bot = Bot::create('1 2 N', 'LMLMLMLMM');

    return $bot;
  }
  
  
}