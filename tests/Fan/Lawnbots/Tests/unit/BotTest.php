<?php

namespace Fan\Lawnbots\Tests\unit;

use Fan\Lawnbots\Entity\Bot;

class BotTest extends \PHPUnit_Framework_TestCase
{

  public function testCreate() {
    $bot = $this->getBot();
    $this->assertInstanceOf('Fan\Lawnbots\Entity\Bot', $bot);
    $this->assertEquals(1, $bot->getX());
    $this->assertEquals(2, $bot->getY());
    $this->assertEquals('LMLMLMLMM', $bot->getCommand());
  }

  public function testCreateWrongPosition() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong position string!');
    $bot = Bot::create('11N', 'S62d8');
  }

  public function testCreateWrongCommand() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong command string!');
    $bot = Bot::create('2 3 S', 'sjfewpnfe21');
  }

  public function testCreateWrongXPostion() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong x position!');
    $bot = $this->getBot();
    $bot->setX('x');
  }

  public function testCreateWrongPostion() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong y position!');
    $bot = $this->getBot();
    $bot->setY('y');
  }

  public function testCreateWrongHeading() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong heading!');
    $bot = $this->getBot();
    $bot->setHeading('999');
  }

  public function testtoString() {
    $bot = $this->getBot();
    $this->assertEquals('1 2 N', (string) $bot);

    $bot->setX(3);
    $bot->setY(5);
    $bot->setHeading('W');
    $this->assertEquals('3 5 W', (string) $bot);
  }

  public function getBot() {
    $bot = Bot::create('1 2 N', 'LMLMLMLMM');

    return $bot;
  }


}