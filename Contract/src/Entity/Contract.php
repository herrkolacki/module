<?php
namespace Contract\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a companies.
 * @ORM\Entity()
 * @ORM\Table(name="contracts")
 */
class Contract
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
     * @ORM\Column(name="product_id")
     */
    protected $productId;

    /**
     * @ORM\Column(name="payment_id")
     */
    protected $paymentId;

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
     * Returns  product_id
     * @return int
     */
    public function getProductId():int
    {
        return $this->productId;
    }

    /**
     * Sets  product_id.
     * @param string $modified
     */
    public function setProductId(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getPymentId():int
    {
        return $this->paymentId;
    }


    /**
     * Sets  nip.
     * @param string nip
     */
    public function setPaymentId(int $paymentId)
    {
        $this->paymentId = $paymentId;
    }
}



