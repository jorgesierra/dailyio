<?php
namespace Dailyio\Entity;

use Sitescore\Exception\DomainException;
use Doctrine\ORM\Mapping as ORM;
use Zend\Db\Sql\Ddl\Column\Boolean;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_backlog")
 * @author jorgesierra
 *
 */
class PagebacklogEntity
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
     * @ORM\Column(type="text", name="page_backlogdata")
     * @var string
     */
    private $_page_backlogdata;

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
     * @return the $_page_backlogdata
     */
    public function getPage_backlogdata ()
    {
        return $this->_page_backlogdata;
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
     * @param string $_page_data
     */
    public function setPage_backlogdata($_page_backlogdata)
    {
        $this->_page_backlogdata = $_page_backlogdata;
    }
}