<?php

namespace Fan\Lawnbots\Entity;

abstract class BaseEntity
{
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="bigint", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  public function __get($property){
    return $this->{$property};
  }

  public function __set($property, $value) {
    $this->{$property} = $value;

    return $this;
  }

  public function __call($method, $arguments){
    if (in_array($verb = substr($method, 0, 3), array('set', 'get'))) {
      print_r($arguments); die();
    }
  }

}