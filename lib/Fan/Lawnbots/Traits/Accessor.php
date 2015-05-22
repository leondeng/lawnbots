<?php

namespace Fan\Lawnbots\Traits;

use Doctrine\Common\Inflector\Inflector;

trait Accessor
{
  public function get($property){
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  public function set($property, $value) {
    if (property_exists($this, $property)) {
      $this->$property = $value;
    }

    return $this;
  }

  public function __call($method, $arguments){
    $failed = false;
    try {
      if (in_array($verb = substr($method, 0, 3), array('set', 'get'))) {
        $prop = Inflector::camelize(substr($method, 3));

        $refl = new \ReflectionObject($this);
        if ($refl->hasProperty($prop)) {
          array_unshift($arguments, $prop);
          return call_user_func_array(array($this, $verb), $arguments);
        }
      }
    } catch(\Exception $e) {
      throw $e;
    }
  }
}