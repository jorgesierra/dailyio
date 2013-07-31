<?php

namespace Dailyio\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 *
 */
class PageController extends AbstractRestfulController
{
	/**
	 * Return list of resources
	 *
	 * @return array
	 */
	public function getList()
	{	    
	    
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
        
        if(isset($data['page_hash'])) {
            $Page = $PageService->findByPageHash($data['page_hash']);
            if(isset($data['bookmarked'])) {
                $Page->setBookmarked($data['bookmarked']);
            }
        } else {
            $Page = $PageService->create();
            $Page->setName($data['name']);
        }

	    $Page = $PageService->persist($Page);
	    
	    $returnData = array("page_hash" => $Page->getPage_hash());
	    
	    return new JsonModel(array(
	        'data' => $returnData,
	    ));
	}

	/**
	 * Update an existing resource
	 *
	 * @param mixed $id
	 * @param mixed $data
	 * @return mixed
	 */
	public function update($id, $data) {
	    
	}

	/**
	 * Delete an existing resource
	 *
	 * @param  mixed $id
	 * @return mixed
	 */
	public function delete($id) {}
}
