<?php

namespace DIPcms\LightTextManager\Entits;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class Texts extends BaseEntity{
    
    
    use Identifier;
    
    /**
     * @ORM\Column(type="string")
     */
    public $name;
    
    
    /**
     * @ORM\Column(type="string")
     */
    public $page;
    
    
    /**
     * @ORM\Column(type="string", length=100000)
     */
    public $text;
    


}

