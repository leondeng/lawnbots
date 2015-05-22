<?php

namespace  Fan\Lawnbots\Entity;

use Doctrine\ORM\Mapping as ORM;

/*
 * @ORM\Entity
 * @ORM\Table(name="bot")
 */
class Bot extends BaseEntity
{
  use \Fan\Lawnbots\Traits\Accessor;

  private $x;

  private $y;

  private $heading;

  private $command;

  public function __construct($position) {
    $params = explode(' ', $position);
    if (count($params) !== 3) {
     throw new \InvalidArgumentException('Invalid position string!');
    }

    $this->initialize($params);
  }

  private function initialize(array $params) {
    $this->setX($params[0]);
    $this->setY($params[1]);
    $this->setHeading($params[2]);
  }

  public static function create($postion, $command) {
    $bot = new Bot($postion);
    $bot->setCommand($command);

    return $bot;
  }

  public function setX($x) {
    if (!is_numeric($x)) {
      throw new \InvalidArgumentException('Invalid x position!');
    }

    $this->x = (int) $x;

    return $this;
  }

  public function setY($y) {
    if (!is_numeric($y)) {
      throw new \InvalidArgumentException('Invalid y position!');
    }

    $this->y = (int) $y;

    return $this;
  }

  public function setHeading($heading) {
    if (!in_array($heading, array('N', 'S', 'E', 'W'))) {
      throw new \InvalidArgumentException('Invalid heading!');
    }

    $this->heading = $heading;

    return $this;
  }

  public function setCommand($command) {
    if (!preg_match('/^[LRM]+$/', $command)) {
      throw new \InvalidArgumentException('Invalid command string!');
    }

    $this->command = $command;

    return $this;
  }

  public function __toString() {
    return sprintf('%d %d %s', $this->x, $this->y, $this->heading);
  }
}