<?php
namespace Dailyio\Entity;

use Sitescore\Exception\DomainException;
use Doctrine\ORM\Mapping as ORM;
use Zend\Db\Sql\Ddl\Column\Boolean;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages")
 * @author jorgesierra
 *
 */
class PageEntity
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
     * @ORM\Column(type="string", name="page_hash", length=32)
     * @var string
     */
    private $_page_hash;
    
    /**
     * @ORM\Column(type="string", name="name", length=64)
     * @var string
     */
    private $_name;
    
    /**
     * @ORM\Column(type="datetime", name="created")
     * @var \DateTime
     */
    private $_created;
    
    /**
     * @ORM\Column(type="boolean", name="bookmarked", options={"default" = 0})
     * @var Boolean
     */
    private $_bookmarked = false;
	
    /**
     * @ORM\Column(type="string", name="team", length=64, nullable=TRUE, options={"default" = "Case"})
     * @var string
     */
    private $_team;
    
    /**
     * @ORM\OneToMany(targetEntity="PagedataEntity", mappedBy="page")
     */
    private $page_data;
    
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
     * @return the $_page_hash
     */
    public function getPage_hash ()
    {
        return $this->_page_hash;
    }

	/**
     * @return the $_name
     */
    public function getName ()
    {
        return $this->_name;
    }

	/**
     * @return the $_created
     */
    public function getCreated ()
    {
        return $this->_created;
    }

	/**
     * @return the $page_data
     */
    public function getPage_data ()
    {
        return $this->page_data;
    }

	/**
     * @param number $_id
     */
    public function setId ($_id)
    {
        $this->_id = $_id;
    }

	/**
     * @param string $_page_hash
     */
    public function setPage_hash ($_page_hash)
    {
        $this->_page_hash = $_page_hash;
    }

	/**
     * @return the $_bookmarked
     */
    public function getBookmarked ()
    {
        return $this->_bookmarked;
    }

	/**
     * @param \Zend\Db\Sql\Ddl\Column\Boolean $_bookmarked
     */
    public function setBookmarked ($_bookmarked)
    {
        $this->_bookmarked = $_bookmarked;
    }

	/**
     * @param string $_name
     */
    public function setName ($_name)
    {
        $this->_name = $_name;
    }

	/**
     * @param DateTime $_created
     */
    public function setCreated ($_created)
    {
        $this->_created = $_created;
    }

    /**
     * @return the $_team
     */
    public function getTeam ()
    {
        return $this->_team;
    }
}