<?php
namespace Dailyio\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use \Doctrine\ORM\EntityManager;
use \Dailyio\Exception\InvalidArgumentException;
use \Dailyio\Entity\PageEntity;

class PageService implements ServiceLocatorAwareInterface
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
	 * @return \Dailyio\Entity\Page[]
	 */
	public function findAll()
	{
	    return $this->getEntityManager()->getRepository('Dailyio\Entity\PageEntity')->findAll();
	}
	
	/**
	 * 
	 * @param integer $id
	 * @return Dailyio\Entity\Page
	 */
	public function find($id)
	{
	    return $this->getEntityManager()->getRepository('Dailyio\Entity\PageEntity')->find($id);
	}
	
	/**
	 *
	 * @param string $hash
	 * @return Dailyio\Entity\Page
	 */
	public function findbyPageHash($hash)
	{
	    return $this->getEntityManager()->getRepository('Dailyio\Entity\PageEntity')->findOneBy(array('_page_hash' => $hash));
	}
	
	/**
	 *
	 */
	public function create() {
	
	    $Page = $this->getServiceLocator()->get('Dailyio\Entity\Page');
	
	    return $Page;
	}
	
	/**
	 *
	 * @param PageEntity $Page
	 */
	public function persist(PageEntity $Page)
	{
	    $Page->setPage_hash($this->createPageHash($Page->getName()));
	    $this->getEntityManager()->persist($Page);
	    $this->getEntityManager()->flush();
	    return $Page;
	}
	
	/**
	 * @param string $name
	 */
	public function createPageHash($name)
	{
	    return md5($name.time().rand ( 1, 100 ));
	}
}