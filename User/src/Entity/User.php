<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User 
{
    // User status constants.
    const STATUS_ACTIVE       = 1; // Active user.
    const STATUS_RETIRED      = 0; // Retired user.
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** 
     * @ORM\Column(name="email")  
     */
    protected $email;
    
    /** 
     * @ORM\Column(name="username")
     */
    protected $username;

    /** 
     * @ORM\Column(name="password")  
     */
    protected $password;

    /** 
     * @ORM\Column(name="active")
     */
    protected $active;
    
    /**
     * @ORM\Column(name="created")
     */
    protected $created;

    /**
     * @ORM\Column(name="role_id")
     */
    protected $roleId;

    /**
     * @ORM\Column(name="token")
     */
    protected $token;
    
    /**
     * @ORM\Column(name="token_expire")
     */
    protected $tokenExpire;


    /**
     * Returns user ID.
     * @return integer
     */
    public function getId() 
    {
        return $this->id;
    }

    /**
     * Sets user ID. 
     * @param int $id    
     */
    public function setId($id) 
    {
        $this->id = $id;
    }

    /**
     * Returns email.     
     * @return string
     */
    public function getEmail() 
    {
        return $this->email;
    }

    /**
     * Sets email.     
     * @param string $email
     */
    public function setEmail($email) 
    {
        $this->email = $email;
    }
    
    /**
     * Returns full name.
     * @return string     
     */
    public function getUsername()
    {
        return $this->username;
    }       

    /**
     * Sets full name.
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * Returns status.
     * @return int     
     */
    public function getActive():int
    {
        return $this->active;
    }

    /**
     * Returns possible statuses as array.
     * @return array
     */
    public static function getStatusList() 
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_RETIRED => 'Retired'
        ];
    }    
    
    /**
     * Returns user status as string.
     * @return string
     */
    public function getStatusAsString()
    {
        $list = self::getStatusList();
        if (isset($list[$this->active]))
            return $list[$this->active];
        
        return 'Unknown';
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

    /**
     * @return int
     */
    public function getRoleId():int
    {
        return $this->roleId;
    }

    /**
     * @param int $roleId
     */
    public function setRoleId(int $roleId)
    {
        $this->roleId = $roleId;
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
     * Sets the date when this user was created.
     * @param string $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }    
    
    /**
     * Returns password reset token.
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
    
    /**
     * Sets password reset token.
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
    
    /**
     * Returns password reset token's creation date.
     * @return string
     */
    public function getTokenExpire()
    {
        return $this->tokenExpire;
    }
    
    /**
     * Sets password reset token's creation date.
     * @param string $date
     */
    public function setTokenExpire($date)
    {
        $this->tokenExpire = $date;
    }
}



