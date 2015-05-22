<?php

namespace  Fan\Lawnbots\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/*
 * @ORM\Entity
 * @ORM\Table(name="lawn")
 */
class Lawn extends BaseEntity
{
  use \Fan\Lawnbots\Traits\Accessor;

  /*
   * @var int
   */
  private $width;

  /*
   * @var int
   */
  private $height;

  /*
   * @var ArrayCollection
   */
  private $bots;

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

    $this->bots = new ArrayCollection();
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

  public function addBot(Bot $bot) {
    if ($this->validateBot($bot)) {
      $this->bots[] = $bot;
      $bot->setLawn($this);
    }

    return $this;
  }

  public function removeBot(Bot $bot) {
    $this->bots->removeElement($bot);
  }

  private function validateBot(Bot $bot) {
    if ($bot->getX() >= $this->width) {
      throw new \Exception('Invalid x postion of bot, out of width of lawn!');
    } elseif ($bot->getY() >= $this->height) {
      throw new \Exception('Invalid y postion of bot, out of height of lawn!');
    } else {
      return true;
    }
  }

  public function __toString() {
    return sprintf('%d %d', $this->width, $this->height);
  }
}