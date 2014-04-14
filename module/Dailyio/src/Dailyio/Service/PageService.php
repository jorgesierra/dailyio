<?php
namespace Dailyio\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use \Doctrine\ORM\EntityManager;
use \Dailyio\Exception\InvalidArgumentException;
use \Dailyio\Entity\PageEntity;

class PageService implements ServiceLocatorAwareInterface
{
	const settings = '{"backlog":{"AMITB":true,"MUITB":false}}';

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
	    $Page = $this->getEntityManager()->getRepository('Dailyio\Entity\PageEntity')->findOneBy(array('_page_hash' => $hash));
	    if(!$Page->getSettings()) {
	    	$Page->setSettings($this::settings);
	    	$Page = $this->persist($Page);
	    }
	    return $Page;
	}

	/**
	 *
	 * @param Page $page
	 * @return string
	 */
	public function findLastActivityDate($Page, $fromDateStr = null)
	{
	    $fromDateSql = "";
	    if($fromDateStr != null) {
	        $fromDateSql = " AND pd.page_date < '".$fromDateStr."' ";
	    }

	    $sql = "
        SELECT pd.page_date
          FROM pages p, pages_data pd
	      WHERE p.id = pd.page_id
	           AND p.id = '".$Page->getId()."'
	           AND pd.page_data <> 'null'
	           AND pd.page_date <> '".date('Y-m-d')."'".$fromDateSql."
		  ORDER BY pd.page_date DESC LIMIT 1;
        ";

	    $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
	    $stmt->execute();
	    $result = $stmt->fetchAll();

	    if($result !== NULL && isset($result[0])) {
	    	return $result[0]['page_date'];
	    }

	    return null;
	}

	/**
	 *
	 */
	public function create() {

	    $Page = $this->getServiceLocator()->get('Dailyio\Entity\Page');
	    $Page->setSettings($this::settings);

	    return $Page;
	}

	/**
	 *
	 * @param PageEntity $Page
	 */
	public function persist(PageEntity $Page)
	{
	    if(!$Page->getPage_hash()) {
	       $Page->setPage_hash($this->createPageHash($Page->getName()));
	    }
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

	/**
	 * 
	 */
	public function getSettingsDescription() {
		return array(
			"AMITB" => "Automatically copy the day before's uncompleted tasks to the backlog",
			"MUITB" => "Remove a day before's uncompleted task when copied to backlog"
		);
	}
}