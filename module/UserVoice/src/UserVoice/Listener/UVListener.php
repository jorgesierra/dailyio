<?php
namespace UserVoice\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Model\ViewModel;
use Zend\Console\Console;
use Zend\Crypt\PublicKey\Rsa\PublicKey;

/**
 * Injects Uservoice script in the page
 *
 * @author diego
 *        
 */
class UVListener implements ListenerAggregateInterface
{
    /**
     * @var array
     */    
    protected $config;
    /**
     *
     * @var RendererInterface
     */
    protected $renderer;

    /**
     *
     * @var array
     */
    protected $listeners = array();
    

    public function __construct(RendererInterface $viewRenderer,  array $config)
    {
        $this->setConfig($config);
        
        $this->renderer = $viewRenderer;
    }
    
    public function setConfig($config){
    	$this->config = $config;
    }

    public function attach(\Zend\EventManager\EventManagerInterface $events)
    {
        if (! Console::isConsole()) {
            $events->attach(MvcEvent::EVENT_FINISH, array(
                $this,
                'injectUVCode'
            ), 1000);
        }
    }

    public function detach(\Zend\EventManager\EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function injectUVCode($event)
    {   
        
        //getRoutes
        $router = $event->getRouteMatch();
        
        if($router!=null){
        	//not check the errors
            $routeName = $router->getMatchedRouteName();
            $allowedRoute = 0;
            do{
                $testRoute =  current($this->config['routes']);
                $allowedRoute = preg_match("/{$testRoute}/",$routeName);
            }
            while(($testRoute = next($this->config['routes'])) && $allowedRoute == 0);
            //if the route is 0, the route dont need the user voice plugin
            if($allowedRoute == 0){
            	return;
            }
        }
        
        
        $response = $event->getApplication()->getResponse();
        
        $ViewModel = new ViewModel();
        $ViewModel->setTemplate('uv-script/uv-script');

        $ViewModel->setTerminal(true);
        
        $ga_code = $this->renderer->render($ViewModel);
        
        $injected = preg_replace('/<\/body>/i', $ga_code . "\n</body>", $response->getBody(), 1);
        $response->setContent($injected);
    }
}
