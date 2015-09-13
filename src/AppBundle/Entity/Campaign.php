<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="campaign")
 * @ORM\Entity
 */
class Campaign
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /*
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $start_date;
    
    /*
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $end_date;

    /*
     * @var integer
     *
     * @ORM\Column(name="number_free_projects", type="integer")
     */
    private $number_free_projects;

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
     * Get start_date
     *
     * @return datetime 
     */
    public function getStart_date()
    {
        return $this->start_date;
    }
    /*
     * Get end_date
     *
     * @return datetime 
     */
    public function getEnd_date()
    {
        return $this->end_date;
    }
    /*
     * Get Number_free_projects
     *
     * @return integer 
     */
    public function getNumber_free_projects()
    {
        return $this->number_free_projects;
    }
    
}