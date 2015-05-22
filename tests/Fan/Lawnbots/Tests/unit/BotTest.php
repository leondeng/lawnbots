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

  public function testCreateInvalidPosition() {
    $this->setExpectedException('InvalidArgumentException', 'Invalid position string!');
    $bot = Bot::create('11N', 'S62d8');
  }

  public function testCreateInvalidCommand() {
    $this->setExpectedException('InvalidArgumentException', 'Invalid command string!');
    $bot = Bot::create('2 3 S', 'sjfewpnfe21');
  }

  public function testCreateInvalidXPostion() {
    $this->setExpectedException('InvalidArgumentException', 'Invalid x position!');
    $bot = $this->getBot();
    $bot->setX('x');
  }

  public function testCreateInvalidPostion() {
    $this->setExpectedException('InvalidArgumentException', 'Invalid y position!');
    $bot = $this->getBot();
    $bot->setY('y');
  }

  public function testCreateInvalidHeading() {
    $this->setExpectedException('InvalidArgumentException', 'Invalid heading!');
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