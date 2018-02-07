<?php
namespace Company\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a companies.
 * @ORM\Entity()
 * @ORM\Table(name="companies")
 */
class Company
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
     * @ORM\Column(name="name")
     */
    protected $name;


    /**
     * @ORM\Column(name="created")
     */
    protected $created;

    /**
     * @ORM\Column(name="modified")
     */
    protected $modified;

    /**
     * @ORM\Column(name="nip")
     */
    protected $nip;

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
     * @return mixed
     */
    public function getNip()
    {
        return $this->nip;
    }


    /**
     * Sets  nip.
     * @param string nip
     */
    public function setNip($nip)
    {
        $this->nip = $nip;
    }
}



