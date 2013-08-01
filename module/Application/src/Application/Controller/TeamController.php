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
            $date = new \DateTime();
        } else {
            $date = \DateTime::createFromFormat('Y-m-d', $date);
        }

        return new ViewModel(array(
            "day" => $date->format('D d/m'),
            "dbday" => $date->format('Y-m-d'),
            "team" => $team,
            "year" => $date->format('Y'),
        ));
    }
}
