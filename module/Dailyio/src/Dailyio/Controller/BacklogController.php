<?php

namespace Dailyio\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 *
 */
class BacklogController extends AbstractRestfulController
{
	/**
	 * Return list of resources
	 *
	 * @return array
	 */
	public function getList()
	{	
	    $page_hash = $this->params()->fromQuery('page_hash', 0);

	    $PageService = $this->getServiceLocator()->get('Dailyio\Service\Page');
	    $PagebacklogService = $this->getServiceLocator()->get('Dailyio\Service\Pagebacklog');
	    
	    $Page = $PageService->findByPageHash($page_hash);

		$backlogData = array();
	    $Backlog = $PagebacklogService->findbyPage($Page);

	    if($Backlog) {
	    	$backlogData = $Backlog->getPage_backlogdata();
	    	if($backlogData && $backlogData != 'null') {
	       		$backlogData = json_decode($backlogData);
	       	}
	    }

	    $returnData = array('items' => $backlogData);
	    
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
	public function get($id) {

	}

	/**
	 * Create a new resource
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function create($data) {
	    $PageService = $this->getServiceLocator()->get('Dailyio\Service\Page');
	    $PagebacklogService = $this->getServiceLocator()->get('Dailyio\Service\Pagebacklog');
	    
	    $Page = $PageService->findByPageHash($data['page_hash']);
	    
	    $Backlog = $PagebacklogService->findbyPage($Page);
	    
	    if($Backlog == null) {
	        $Backlog = $PagebacklogService->create();
	        $Backlog->setPage($Page);
	    }
	    
	    $Backlog->setPage_backlogdata(json_encode($data['page_backlogdata']));
	    $Backlog = $PagebacklogService->persist($Backlog);

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
