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
    if ($bot->getX() > $this->width) {
      throw new \Exception('Invalid x postion of bot, out of width of lawn!');
    }

    if ($bot->getY() > $this->height) {
      throw new \Exception('Invalid y postion of bot, out of height of lawn!');
    }

    if ($this->detectOverStep($bot)) {
      throw new \Exception('Bad command of bot, overstep of boundary detected!');
    }

    if ($this->detectCollision($bot)) { // this bot route bump into any other existing bot, or run over any other existing bot
      throw new \Exception('Bad command of bot, bots collision detected!');
    }

    return true;
  }

  private function detectOverStep(Bot $bot) {
    $sequence = $bot->getSequence();

    foreach ($sequence as $position) {
      if ($position['x'] < 0 ||
          $position['y'] < 0 ||
          $position['x'] > $this->width ||
          $position['y'] > $this->height) {
        return true;
      }
    }

    return false;
  }

  private function detectCollision(Bot $newBot) {
    if (!count($this->bots)) return false;

    $newSeq = $newBot->getSequence();
    foreach ($this->bots as $bot) {
      $seq = $bot->getSequence();
      foreach ($seq as $time => $position) {
        if ($newSeq[$time]['x'] === $position['x'] &&
             $newSeq[$time]['y'] === $position['y']) {
          return true;
        }
      }
    }

    return false;
  }

  public function __toString() {
    return sprintf('%d %d', $this->width, $this->height);
  }
}