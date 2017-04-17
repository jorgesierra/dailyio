<?php
namespace Dailyio\Entity;

use Dailyio\Exception\DomainException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_data")
 * @author jorgesierra
 *
 */
class PagedataEntity
{
    /**
     * 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="PageEntity")
     */
    private $page;
    
    /**
     * @ORM\Column(type="date", name="page_date")
     * @var \Date
     */
    private $_page_date;
    
    /**
     * @ORM\Column(type="text", name="page_data")
     * @var string
     */
    private $_page_data;
    
    /**
     * @ORM\Column(type="datetime", name="created")
     * @var \DateTime
     */
    private $_created;
	
    public function __construct() {
        $this->_created = new \DateTime();
    }
    
	/**
     * @return the $_id
     */
    public function getId ()
    {
        return $this->_id;
    }

	/**
     * @return the $page
     */
    public function getPage ()
    {
        return $this->page;
    }

	/**
     * @return the $_page_date
     */
    public function getPage_date ()
    {
        return $this->_page_date;
    }

	/**
     * @return the $_page_data
     */
    public function getPage_data ()
    {
        return $this->_page_data;
    }

	/**
     * @return the $_created
     */
    public function getCreated ()
    {
        return $this->_created;
    }

	/**
     * @param number $_id
     */
    public function setId ($_id)
    {
        $this->_id = $_id;
    }

	/**
     * @param field_type $page
     */
    public function setPage ($page)
    {
        $this->page = $page;
    }

	/**
     * @param Date $_page_date
     */
    public function setPage_date ($_page_date)
    {
        $this->_page_date = $_page_date;
    }

	/**
     * @param string $_page_data
     */
    public function setPage_data ($_page_data)
    {
        $this->_page_data = $_page_data;
    }

	/**
     * @param DateTime $_created
     */
    public function setCreated ($_created)
    {
        $this->_created = $_created;
    }
}