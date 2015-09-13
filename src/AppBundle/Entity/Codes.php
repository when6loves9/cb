<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="codes")
 * @ORM\Entity
 */
class Codes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="used", type="boolean")
     */
    private $used;

    /**
     * @var integer
     *
     * @ORM\Column(name="code", type="integer")
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="campaign_id", type="integer")
     */
    private $campaign_id;


    /*
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   
    /*
     * Get code
     *
     * @return integer 
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * Set used
     *
     * @param integer $used
     * @return Code
     */
    public function setUsed($used)
    {
        $this->used = $used;

        return $this;
    }

       /*
     * Get $campaign_id
     *
     * @return integer 
     */
    public function getCampaign_id()
    {
        return $this->campaign_id;
    }
    
     /*
     * Get used
     *
     * @return integer 
     */
    public function getUsed()
    {
        return $this->used;
    }
}