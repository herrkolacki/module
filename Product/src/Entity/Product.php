<?php
namespace Product\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="products")
 */
class Product
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** 
     * @ORM\Column(name="user_id")
     */
    protected $userId;

    /**
     * @ORM\Column(name="insurer_id")
     */

    protected $insurerId;
    /** 
     * @ORM\Column(name="active")
     */
    protected $active;

    /** 
     * @ORM\Column(name="name")
     */
    protected $name;

    /** 
     * @ORM\Column(name="description")
     */
    protected $description;
    
    /**
     * @ORM\Column(name="created")
     */
    protected $created;

    /**
     * @ORM\Column(name="modified")
     */
    protected $modified;

    /**
     * @ORM\Column(name="access_code")
     */
    protected $accessCode;
    

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
     * Gets insured_id.
     * @param int $insureid
     */
    public function getInsurerId() : int
    {
        return $this->insurerId;
    }

    /**
     * Sets insured_id.
     * @param int $insurerIdl
     */
    public function setInsurerId(int $insurerId)
    {
        $this->insurerId = $insurerId;
    }

    /**
     * Gets insured_id.
     * @param int $userId
     */
    public function getUserId() : int
    {
        return $this->userId;
    }

    /**
     * Sets insured_id.
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->insurerId = $userId;
    }

    /**
     * Returns active.
     * @return int
     */
    public function getActive():int
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

    /**
     * Returns  description.
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets  description.
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the date of user creation.
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Sets the date when this project was created.
     * @param string $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Returns  modified.
     * @return string
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Sets  modified.
     * @param string $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * Returns  access_code.
     * @return string
     */
    public function getAccessCode()
    {
        return $this->accessCode;
    }

    /**
     * Sets  access_code.
     * @param string $accessCode
     */
    public function setAccessCode($accessCode)
    {
        $this->accessCode = $accessCode;
    }
}



