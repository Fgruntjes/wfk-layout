<?php
namespace WfkLayout\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ModuleEnabled extends AbstractHelper
{
    /**
     * @var array
     */
    protected $enabledModules = array();

    /**
     * @param array $enabledModules
     */
    public function __construct(array $enabledModules)
    {
        $this->enabledModules = array_map('strtolower', $enabledModules);
    }

    /**
     * @param string $module
     * @return bool
     */
    public function __invoke($module)
    {
        return in_array(strtolower($module), $this->enabledModules);
    }
}
