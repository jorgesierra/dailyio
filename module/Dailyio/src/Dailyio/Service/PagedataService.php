<?php
namespace Dailyio\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use \Doctrine\ORM\EntityManager;
use \Dailyio\Exception\InvalidArgumentException;
use \Dailyio\Entity\PagedataEntity;

class PagedataService implements ServiceLocatorAwareInterface
{
    /**
     * 
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $_sl;
    
    /**
     * 
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->_sl = $serviceLocator;
    }
    
    public function getServiceLocator() {
        return $this->_sl;
    }
    
    public function setEntityManager(EntityManager $entityManager) {
        $this->_em = $entityManager;
    }
    
    public function getEntityManager() {
        return $this->_em;
    }
    
    /**
	 * 
	 * @return \Dailyio\Entity\Pagedata[]
	 */
	public function findAll()
	{
	    return $this->getEntityManager()->getRepository('Dailyio\Entity\PagedataEntity')->findAll();
	}
	
	/**
	 * 
	 * @param integer $id
	 * @return Dailyio\Entity\Pagedata
	 */
	public function find($id)
	{
	    return $this->getEntityManager()->getRepository('Dailyio\Entity\PagedataEntity')->find($id);
	}
	
	/**
	 *
	 * @param string $hash
	 * @return Dailyio\Entity\Page
	 */
	public function findbyPageAndDate($Page, $date)
	{
	    return $this->getEntityManager()->getRepository('Dailyio\Entity\PagedataEntity')->findOneBy(array('page' => $Page, '_page_date' => $date));
	}
	
	/**
	 *
	 */
	public function create() {
	
	    $Pagedata = $this->getServiceLocator()->get('Dailyio\Entity\Pagedata');
	
	    return $Pagedata;
	}
	
	/**
	 *
	 * @param PageEntity $Page
	 */
	public function persist(PagedataEntity $Pagedata)
	{
	    $this->getEntityManager()->persist($Pagedata);
	    $this->getEntityManager()->flush();
	    return $Pagedata;
	}
}