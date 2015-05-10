<?php

namespace vova07\bank\traits;

use vova07\bank\Module;

/**
 * Class ModuleTrait
 * @package vova07\bank\traits
 * Implements `getModule` method, to receive current module instance.
 */
trait ModuleTrait
{
    /**
     * @var \vova07\bank\Module|null Module instance
     */
    private $_module;

    /**
     * @return \vova07\bank\Module|null Module instance
     */
    public function getModule()
    {
        if ($this->_module === null) {
            $this->_module = Module::getInstance();
        }
        return $this->_module;
    }
}
