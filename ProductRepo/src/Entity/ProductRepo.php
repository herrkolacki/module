<?php
namespace ProductRepo\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="product_repos")
 */
class ProductRepo
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
     * @ORM\Column(name="created")
     */
    protected $created;

    /**
     * @ORM\Column(name="type")
     */
    protected $type;


    /** 
     * @ORM\Column(name="name")
     */
    protected $name;



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
     * Gets active
     * @param int $active
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
     * Gets created
     * @param $created
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Sets created.
     * @param created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Returns type
     * @return string type
     */
    public function getType():string
    {
        return $this->type;
    }

    /**
     * Sets active.
     * @param int $active
     */
    public function setType(string $active)
    {
        $this->active = $active;
    }

    /**
     * Returns  name.
     * @return string     
     */
    public function getName()
    {
        return $this->name;
    }       

    /**
     * Sets  name.
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}



