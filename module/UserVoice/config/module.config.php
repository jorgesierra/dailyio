<?php

return array(
    'UserVoice' => array(
	   'enabled' => false,
       'routes' => array(
    	   
        ), 
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'UserVoice' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'UserVoice\Listener\UVListener' => function (Zend\ServiceManager\ServiceManager $sm)
            {
                $options = $sm->get('Config');
                return new UserVoice\Listener\UVListener($sm->get('ViewRenderer'), $options['UserVoice']);
            }
        ),
    ),
);
