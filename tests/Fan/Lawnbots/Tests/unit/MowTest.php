<?php

namespace Fan\Lawnbots\Tests\unit;

use Fan\Lawnbots\Entity\Lawn;
use Fan\Lawnbots\Entity\Bot;
use Fan\Lawnbots\Drivers\Mow;

class MowTest extends \PHPUnit_Framework_TestCase
{

  public function testCreate() {
    $mow = $this->getMow();
    $this->assertInstanceOf('Fan\Lawnbots\Drivers\Mow', $mow);
    $this->assertInstanceOf('Fan\Lawnbots\Entity\Lawn', $mow->getLawn());
    /* foreach ($mow->getBots() as $bot) {
      $this->assertInstanceOf('Fan\Lawnbots\Entity\Bot', $bot);
    } */
  }

  public function testCreateInvalidInput() {
    $this->setExpectedException('InvalidArgumentException', 'Invalid input string!');
    $mow = Mow::create('xxx');
  }

  public function testCreateInvalidLawn() {
    $this->setExpectedException('InvalidArgumentException', 'Invalid width!');
    $mow = Mow::create('s s 6');
  }

  public function testCreateInvalidBotsNumber() {
    $this->setExpectedException('InvalidArgumentException', 'Invalid bots number!');
    $mow = Mow::create('4 4 invliad');
  }

  public function testGenerateInstructions() {
    $mow = $this->getMow();
    $instructions = $mow->generateInstructions();
    $this->assertEquals('blahblah', $instructions);
  }

  public function getMow() {
    $mow = Mow::create('5 5 3');

    return $mow;
  }

}