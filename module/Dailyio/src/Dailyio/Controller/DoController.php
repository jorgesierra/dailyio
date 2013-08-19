<?php

namespace Dailyio\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 *
 */
class DoController extends AbstractRestfulController
{
	/**
	 * Return list of resources
	 *
	 * @return array
	 */
	public function getList()
	{	
	    $page_hash = $this->params()->fromQuery('page_hash', 0);
	    $day = $this->params()->fromQuery('day', 0);
	    $prevday = $this->params()->fromQuery('prevday', 0);
	    
	    $PageService = $this->getServiceLocator()->get('Dailyio\Service\Page');
	    $PagedataService = $this->getServiceLocator()->get('Dailyio\Service\Pagedata');
	    
	    $Page = $PageService->findByPageHash($page_hash);
	    $date = \DateTime::createFromFormat('Y-m-d', $day);
	    
	    $prevdate = \DateTime::createFromFormat('Y-m-d', $prevday);

	    $item = $PagedataService->findByPageAndDate($Page, $date);
	    $previtem = $PagedataService->findByPageAndDate($Page, $prevdate);
	    
	    $itemData = array();
	    $previtemData = array();
	    
	    if($item) {
	    	$itemData = $item->getPage_data();
	    	if($itemData && $itemData != 'null') {
	       		$itemData = json_decode();
	       	}
	    }

	    if($previtem) {
	    	$pageData = $previtem->getPage_data();
	    	if($pageData && $pageData != 'null') {
	       		$previtemData = json_decode($pageData);
	       	}
	    }
	    
	    $returnData = array('items' => $itemData, 'previtems' => $previtemData);
	    
	    return new JsonModel(array(
	        'data' => $returnData,
	    ));
	}

	/**
	 * Return single resource
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function get($id) {}

	/**
	 * Create a new resource
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function create($data) {
	    $PageService = $this->getServiceLocator()->get('Dailyio\Service\Page');
	    $PagedataService = $this->getServiceLocator()->get('Dailyio\Service\Pagedata');
	    
	    $Page = $PageService->findByPageHash($data['page_hash']);
	    $date = \DateTime::createFromFormat('Y-m-d', $data['page_date']);
	    
	    $Pagedata = $PagedataService->findByPageAndDate($Page, $date);
	    
	    if($Pagedata == null) {
	        $Pagedata = $PagedataService->create();
	        $Pagedata->setPage($Page);
	        $Pagedata->setPage_date($date);
	    }
	    
	    $Pagedata->setPage_data(json_encode($data['page_data']));
	    $Pagedata = $PagedataService->persist($Pagedata);

	    return new JsonModel(array(
	        'success' => true,
	    ));
	}

	/**
	 * Update an existing resource
	 *
	 * @param mixed $id
	 * @param mixed $data
	 * @return mixed
	 */
	public function update($id, $data) {}

	/**
	 * Delete an existing resource
	 *
	 * @param  mixed $id
	 * @return mixed
	 */
	public function delete($id) {}
}
