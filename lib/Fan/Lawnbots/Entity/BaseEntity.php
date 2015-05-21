<?php

namespace Fan\Lawnbots\Entity;

use Doctrine\Common\Inflector\Inflector;

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