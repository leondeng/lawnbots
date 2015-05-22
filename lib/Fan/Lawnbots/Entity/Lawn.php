<?php

namespace  Fan\Lawnbots\Entity;

use Doctrine\ORM\Mapping as ORM;

/*
 * @ORM\Entity
 * @ORM\Table(name="lawn")
 */
class Lawn extends BaseEntity
{
  use \Fan\Lawnbots\Traits\Accessor;

  private $width;

  private $height;

  public function __construct($size) {
    $params = explode(' ', $size);
    if (count($params) !== 2) {
     throw new \InvalidArgumentException('Invalid size string!');
    }

    $this->initialize($params);
  }

  private function initialize(array $params) {
    $this->setWidth($params[0]);
    $this->setHeight($params[1]);
  }

  public static function create($size) {
    $lawn = new Lawn($size);

    return $lawn;
  }

  public function setWidth($width) {
    if (!is_numeric($width)) {
      throw new \InvalidArgumentException('Invalid width!');
    }

    $this->width = (int) $width;

    return $this;
  }

  public function setHeight($height) {
    if (!is_numeric($height)) {
      throw new \InvalidArgumentException('Invalid height!');
    }

    $this->height = (int) $height;

    return $this;
  }

  public function __toString() {
    return sprintf('%d %d', $this->width, $this->height);
  }
}