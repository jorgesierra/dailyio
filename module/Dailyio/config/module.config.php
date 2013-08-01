<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dailyio;

return array(
    'service_manager' => array(
        'factories' => array(
            'Dailyio\Service\Page' => function($sm) {
                $PageService = new Service\PageService($sm);
                $PageService->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
                return $PageService;
            },
            'Dailyio\Service\Pagedata' => function($sm) {
                $PagedataService = new Service\PagedataService($sm);
                $PagedataService->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
                return $PagedataService;
            }
        ),
        'invokables' => array(
            'Dailyio\Entity\Page'        => 'Dailyio\Entity\PageEntity',
            'Dailyio\Entity\Pagedata'         => 'Dailyio\Entity\PagedataEntity'
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Dailyio\Controller\Page' => 'Dailyio\Controller\PageController',
            'Dailyio\Controller\Do' => 'Dailyio\Controller\DoController',
            'Dailyio\Controller\Teampage' => 'Dailyio\Controller\TeampageController'
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'do' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/do',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Dailyio\Controller\Do',
                    ),
                ),
            ),
            'page' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/page[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Dailyio\Controller\Page',
                    ),
                ),
            ),
            'teampage' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/teampage[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Dailyio\Controller\Teampage',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);