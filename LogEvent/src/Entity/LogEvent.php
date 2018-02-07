<?php
namespace LogEvent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a products.
 * @ORM\Entity()
 * @ORM\Table(name="log_events")
 */
class LogEvent
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
     * @ORM\Column(name="ip")
     */
    protected $ip;

    /** 
     * @ORM\Column(name="action")
     */
    protected $action;

    /** 
     * @ORM\Column(name="result")
     */
    protected $result;
    
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
     * Gets user_id.
     * @param int $userId
     */
    public function getUserId() : int
    {
        return $this->userId;
    }

    /**
     * Sets userId.
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->insurerId = $userId;
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
     * Returns ip.
     * @return string
     */
    public function getIp():string
    {
        return $this->ip;
    }

    /**
     * Sets ip.
     * @param int $active
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;
    }

    /**
     * Returns  action.
     * @return string     
     */
    public function getAction()
    {
        return $this->action;
    }       

    /**
     * Sets  $action.
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Returns  result.
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Sets  result.
     * @param int result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
}



