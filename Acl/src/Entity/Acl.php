<?php
namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a products.
 * @ORM\Entity()
 * @ORM\Table(name="roles")
 */
class Acl
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** 
     * @ORM\Column(name="active")
     */
    protected $active;

    /**
     * @ORM\Column(name="name")
     */
    protected $name;

    protected $zmora;
    
    /**
     * @return int
     */
    public function getId() :int
    {
        return $this->id;
    }

    /**
     * Sets user ID. 
     * @param int $id    
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Gets active.
     * @param int active
     */
    public function getActive() : int
    {
        return $this->active;
    }

    /**
     * Sets active.
     * @param int $active
     */
    public function setActive(int $active)
    {
        $this->active = $active;
    }


    /**
     * Returns the name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name.
     * @param string $name
     */
    public function setCreated($name)
    {
        $this->name = $name;
    }
}



