<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents passwords history
 * @ORM\Entity()
 * @ORM\Table(name="passwords")
 */
class Password
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
     * @ORM\Column(name="created")
     */
    protected $created;


    /**
     * @ORM\Column(name="password")  
     */
    protected $password;


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
     * Returns user_id.
     * @return string
     */
    public function getUserId() :int
    {
        return $this->userId;
    }

    /**
     * Sets user_id.
     * @param user_id
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Returns created.
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Sets created.
     * @param string $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Returns password.
     * @return string     
     */
    public function getPassword()
    {
        return $this->password;
    }       

    /**
     * Sets password.
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
  }



