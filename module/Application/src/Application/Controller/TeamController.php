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

class TeamController extends AbstractActionController
{
    public function indexAction()
    {
        $team = $this->params()->fromRoute('team', 0);
        $date = $this->params()->fromRoute('date', 0);
        
        if (!$team) {
            return $this->redirect()->toRoute('home', array(
                'action' => 'index'
            ));
        }
        
        if($date == 0) {
            $day = new \DateTime();
            $prevday = new \DateTime();
        } else {
            $day = \DateTime::createFromFormat('Y-m-d', $date);
            $prevday = new \DateTime();
        }

        switch($day->format('D')) {
            case 'Sat':
                $day->add(new \DateInterval('P2D'));
                $prevday->sub(new \DateInterval('P1D'));
                break;
            case 'Sun':
                $day->add(new \DateInterval('P1D'));   
                $prevday->sub(new \DateInterval('P2D'));
                break;
            case 'Mon':
                $prevday->sub(new \DateInterval('P3D'));
                break;
            default:
                $prevday->sub(new \DateInterval('P1D'));
                break;  
        }

        return new ViewModel(array(
            "day" => $day->format('D d/m'),
            "dbday" => $day->format('Y-m-d'),
            "prevday" => $prevday->format('D d/m'),
            "dbprevday" => $prevday->format('Y-m-d'),
            "team" => $team,
            "year" => $day->format('Y'),
        ));
    }
}
