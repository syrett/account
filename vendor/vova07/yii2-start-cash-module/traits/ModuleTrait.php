<?php

namespace vova07\cash\traits;

use vova07\cash\Module;

/**
 * Class ModuleTrait
 * @package vova07\cash\traits
 * Implements `getModule` method, to receive current module instance.
 */
trait ModuleTrait
{
    /**
     * @var \vova07\cash\Module|null Module instance
     */
    private $_module;

    /**
     * @return \vova07\cash\Module|null Module instance
     */
    public function getModule()
    {
        if ($this->_module === null) {
            $this->_module = Module::getInstance();
        }
        return $this->_module;
    }
}
