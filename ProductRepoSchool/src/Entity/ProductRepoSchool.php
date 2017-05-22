<?php
namespace ProductRepoSchool\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a product repo schools.
 * @ORM\Entity()
 * @ORM\Table(name="product_repo_schools")
 */
class ProductRepoSchool
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
     * @ORM\Column(name="product_repo_id")
     */
    protected $productRepoId;


    /** 
     * @ORM\Column(name="comment")
     */
    protected $comment;



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
     * Returns productRepoId
     * @return int productRepoId
     */
    public function getProductRepoId():int
    {
        return $this->productRepoId;
    }

    /**
     * Sets productRepoId.
     * @param int $productRepoId
     */
    public function setProductRepoId(int $productRepoId)
    {
        $this->productRepoId = $productRepoId;
    }

    /**
     * Returns  comment.
     * @return string     
     */
    public function getComment()
    {
        return $this->comment;
    }       

    /**
     * Sets  comment.
     * @param string $comment
     */
    public function seComment($comment)
    {
        $this->comment = $comment;
    }
}



