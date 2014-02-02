<?php
namespace Dailyio\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use \Doctrine\ORM\EntityManager;
use \Dailyio\Exception\InvalidArgumentException;
use \Dailyio\Entity\PagebacklogEntity;

class PagebacklogService implements ServiceLocatorAwareInterface
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
	 * @return \Dailyio\Entity\Pagebacklog[]
	 */
	public function findAll()
	{
	    return $this->getEntityManager()->getRepository('Dailyio\Entity\PagebacklogEntity')->findAll();
	}
	
	/**
	 * 
	 * @param integer $id
	 * @return Dailyio\Entity\Pagebacklog
	 */
	public function find($id)
	{
	    return $this->getEntityManager()->getRepository('Dailyio\Entity\PagebacklogEntity')->find($id);
	}
	
	/**
	 *
	 * @param string $h
	 * @return Dailyio\Entity\Pagebacklog
	 */
	public function findbyPage($Page)
	{
	    return $this->getEntityManager()->getRepository('Dailyio\Entity\PagebacklogEntity')->findOneBy(array('page' => $Page));
	}
	
	/**
	 *
	 */
	public function create() {
	
	    $Pagebacklog = $this->getServiceLocator()->get('Dailyio\Entity\Pagebacklog');
	
	    return $Pagebacklog;
	}
	
	/**
	 *
	 * @param Pagebacklog $Pagebacklog
	 */
	public function persist(PagebacklogEntity $Pagebacklog)
	{
	    $this->getEntityManager()->persist($Pagebacklog);
	    $this->getEntityManager()->flush();
	    return $Pagebacklog;
	}
}