<?php

namespace Dailyio\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 *
 */
class TeampageController extends AbstractRestfulController
{
	/**
	 * Return list of resources
	 *
	 * @return array
	 */
	public function getList()
	{	
	    $team = $this->params()->fromQuery('team', 0);
	    $day = $this->params()->fromQuery('day', 0);
	    
	    $PagedataService = $this->getServiceLocator()->get('Dailyio\Service\Pagedata');
	    $date = \DateTime::createFromFormat('Y-m-d', $day);
	    $itemsData = $PagedataService->findbyTeamAndDate($team, $date);
        
	    $itemsDataArray =  array();
	    
	    if(count($itemsData)>0) {
	        foreach($itemsData as $item) {
	            $itemArray = array();
	            $itemArray['name'] = $item['name'];
	            $itemArray['page_hash'] = $item['page_hash'];
	            $itemArray['page_data'] = json_decode($item['page_data']);
	            $itemsDataArray[] = $itemArray;
	        }
	    }
	    
	    $returnData = array('items' => $itemsDataArray);
	    
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
