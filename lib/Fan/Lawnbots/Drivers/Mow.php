<?php

namespace  Fan\Lawnbots\Drivers;

use Fan\Lawnbots\Entity\Lawn;
use Fan\Lawnbots\Entity\Bot;

class Mow
{

  use \Fan\Lawnbots\Traits\Accessor;

  /*
   * @var Lawn
   */
  private $lawn;

  /*
   * @var integer
   */
  private $botsNum;

  public function __construct($input) {
    $params = explode(' ', $input);
    if (count($params) !== 3) {
     throw new \InvalidArgumentException('Invalid input string!');
    }

    $this->initialize($params);
  }

  private function initialize(array $params) {
    $this->setBotsNum(array_pop($params));
    $size = implode(' ', $params);
    $this->setLawn(Lawn::create($size));
  }

  public static function create($input) {
    $mow = new Mow($input);

    return $mow;
  }

  public function setBotsNum($num) {
    if (!is_numeric($num)) {
      throw new \InvalidArgumentException('Invalid bots number!');
    }

    $this->botsNum = (int) $num;

    return $this;
  }

  public function generateInstructions() {
    throw new \Exception('!Needs implementation!');
  }
}