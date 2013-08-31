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

class WeekController extends AbstractActionController
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
            $weekStart = date('Y-m-d',strtotime('last Sunday'));
            $lastSundayDate = \DateTime::createFromFormat('Y-m-d',$weekStart);

            $weekDays =  array();
            for($i=0;$i<7;$i++) {
                $colTitleDate = $lastSundayDate->format('D d/m');
                $weekDays[$colTitleDate] = $lastSundayDate->format('Y-m-d');
                $lastSundayDate->modify("+1 day");  
            }
        } else {
            $today = \DateTime::createFromFormat('Y-m-d', $date);
            $day = \DateTime::createFromFormat('Y-m-d', $date);
        }

        return new ViewModel(array(
            "day" => $day->format('D d/m'),
            "dbday" => $day->format('Y-m-d'),
            "page_hash" => $page_hash,
            "name" => $Page->getName(),
            "year" => $day->format('Y'),
            "weekDays" => $weekDays,
            "team" => $Page->getTeam()
        ));
    }
}
