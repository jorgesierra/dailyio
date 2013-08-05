<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TodoController extends AbstractActionController
{
    public function indexAction()
    {
        $page_hash = $this->params()->fromRoute('hash', 0);
        $date = $this->params()->fromRoute('date', 0);
        
        if (!$page_hash) {
            return $this->redirect()->toRoute('home', array(
                'action' => 'index'
            ));
        }
        
        $PageService = $this->getServiceLocator()->get('Dailyio\Service\Page');
        $Page = $PageService->findByPageHash($page_hash);
        
        if ($Page == null) {
            return $this->redirect()->toRoute('home', array(
                'action' => 'index'
            ));
        }

        
        
        if($date == 0) {
            $today = new \DateTime();
            $day = new \DateTime();
            $prevday = new \DateTime();
        } else {
            $today = \DateTime::createFromFormat('Y-m-d', $date);
            $day = \DateTime::createFromFormat('Y-m-d', $date);
            $prevday = \DateTime::createFromFormat('Y-m-d', $date);
        }

        $last_activity_date = $PageService->findLastActivityDate($Page);

        if($last_activity_date != null) {
            $prevday = \DateTime::createFromFormat('Y-m-d', $last_activity_date);
        }

        switch($today->format('D')) {
            /*case 'Sat':
                //$day->add(new \DateInterval('P2D'));
                //$prevday->sub(new \DateInterval('P1D'));
                break;
            case 'Sun':
                //$day->add(new \DateInterval('P1D'));   
                //$prevday->sub(new \DateInterval('P2D'));
                break;
            case 'Mon':
                //$prevday->sub(new \DateInterval('P3D'));
                break;*/
            default:
                $prevday->sub(new \DateInterval('P1D'));
                break;  
        }

        return new ViewModel(array(
            "day" => $day->format('D d/m'),
            "dbday" => $day->format('Y-m-d'),
            "prevday" => $prevday->format('D d/m'),
            "dbprevday" => $prevday->format('Y-m-d'),
            "page_hash" => $page_hash,
            "name" => $Page->getName(),
            "year" => $day->format('Y'),
            "bookmarked" => $Page->getBookmarked()
        ));
    }
}
