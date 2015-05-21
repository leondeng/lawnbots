<?php

namespace Fan\Lawnbots\Tests\unit;

use Fan\Lawnbots\Entity\Lawn;

class LawnTest extends \PHPUnit_Framework_TestCase
{

  public function testCreate() {
    $lawn = $this->getLawn();
    $this->assertInstanceOf('Fan\Lawnbots\Entity\Lawn', $lawn);
    $this->assertEquals(5, $lawn->getWidth());
    $this->assertEquals(5, $lawn->getHeight());
  }

  public function testCreateWrongSize() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong size string!');
    $lawn = Lawn::create('xxx');
  }

  public function testCreateWrongWidth() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong width!');
    $lawn = $this->getLawn();
    $lawn->setWidth('width');
  }

  public function testCreateWrongPostion() {
    $this->setExpectedException('InvalidArgumentException', 'Wrong height!');
    $lawn = $this->getLawn();
    $lawn->setHeight('height');
  }

  public function testToString() {
    $lawn = $this->getLawn();
    $this->assertEquals('5 5', (string) $lawn);

    $lawn->setWidth(7);
    $lawn->setHeight(14);
    $this->assertEquals('7 14', (string) $lawn);
  }

  public function getLawn() {
    $lawn = Lawn::create('5 5');

    return $lawn;
  }

}