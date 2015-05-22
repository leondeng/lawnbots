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

  private static $headings = array(
    'W' => 'N',
    'N' => 'E',
    'E' => 'S',
    'S' => 'W'
  );

  /*
   * @var int
   */
  private $x;

  /*
   * @var int
   */
  private $y;

  /*
   * @var char
   */
  private $heading;

  /*
   * @var string
   */
  private $command;

  /*
   * @var Lawn
   */
  private $lawn;

  /*
   * @var array
   */
  private $sequence = null;

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
    if (!in_array($heading, self::$headings)) {
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

  public function getSequence() {
    if ($this->sequence) return $this->sequence;

    $sequence = array();
    $sequence[] = array(
      'x' => $this->x,
      'y' => $this->y,
      'heading' => $this->heading
    );

    foreach (str_split($this->command) as $action) {
      $sequence[] = $this->getNextPosition(end($sequence), $action);
    }

    return $this->sequence = $sequence;
  }

  private function getNextPosition($position, $action) {
    if ($action === 'M') {
      $position = $this->getNextCoordinates($position);
    } else {
      $position = $this->getNextHeading($position, $action);
    }

    return $position;
  }

  private function getNextHeading($position, $direction) {
    if ($direction === 'R') {
      $position['heading'] = self::$headings[$position['heading']];
    } else {
      $flip_headings = array_flip(self::$headings);
      $position['heading'] = $flip_headings[$position['heading']];
    }

    return $position;
  }

  private function getNextCoordinates($position) {
    switch ($position['heading']) {
      case 'N':
        $position['y']++;
        break;
      case 'E':
        $position['x']++;
        break;
      case 'S':
        $position['y']--;
        break;
      case 'W':
        $position['x']--;
        break;
    }

    return $position;
  }

  public function getFinalPosition() {
    $seq = $this->getSequence();

    $position = end($seq);

    return sprintf('%d %d %s', $position['x'], $position['y'], $position['heading']);
  }

  public function reset() {
    $this->x = null;
    $this->y = null;
    $this->heading = null;
    $this->command = null;
    $this->sequence = null;
    $this->lawn = null;
  }

  public function __toString() {
    return sprintf('%d %d %s', $this->x, $this->y, $this->heading);
  }
}