<?php
namespace WfkLayout;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Loader\StandardAutoloader;
use Zend\Loader\AutoloaderFactory;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements
    ConfigProviderInterface,
    AutoloaderProviderInterface,
    ViewHelperProviderInterface,
    ServiceProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'moduleEnabled' => function (ServiceLocatorInterface $sm) {
                    $locator = $sm->getServiceLocator();
                    /** @var $moduleManager \Zend\ModuleManager\ModuleManagerInterface */
                    $moduleManager = $locator->get('ModuleManager');

                    return new View\Helper\ModuleEnabled($moduleManager->getModules());
                },
            ),
        );
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
                'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory'
            ),
        );
    }
}
