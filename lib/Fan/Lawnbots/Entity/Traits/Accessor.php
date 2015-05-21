<?php

namespace Fan\Lawnbots\Entity\Traits;

trait Accessor
{
  public function get($property){ //echo $property; var_dump($this);
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  public function set($property, $value) {
    if (property_exists($this, $property)) { //echo $property.': '.$value; var_dump($this);
      $this->$property = $value; //var_dump($this); die();
    }

    return $this;
  }
}