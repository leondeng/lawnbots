<?php

namespace  Fan\Lawnbots\Entity;

use Doctrine\ORM\Mapping as ORM;

/*
 * @ORM\Entity
 * @ORM\Table(name="bot")
 */
class Bot extends BaseEntity
{


  /**
   * @var string
   *
   * @ORM\Column(name="name", type="string", length=255, nullable=true)
   */
  private $name;
}