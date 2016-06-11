<?php
namespace Zikkio\Policies\Capabilities;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;

abstract class Capability
{
    /**
     *
     * @var string
     */
    protected static $capabilityMethodPrefix = 'can';

    /**
     * Goes through all the class methods and tells the Gate
     * to define as capabilities the appropriate ones
     * @param GateContract $gate
     */
    public static function defineCapabilities(GateContract $gate){
        foreach (get_class_methods(static::class) as $method) {
            if(static::methodShouldBeRegistered($method)) {
                $capability = static::extractCapabilityNameFromMethodName($method);
                $gate->define($capability, static::class . "@{$method}");
            }
        }
    }

    /**
     * Determines if the given method is intended to serve as a capability
     * @param $methodName
     * @return bool
     */
    protected static function methodShouldBeRegistered($methodName){
        return starts_with($methodName, static::$capabilityMethodPrefix);
    }

    /**
     * Extracts capability name
     * Ex. methodName: "canTest" => capability: "test"
     * @param $methodName
     * @return string
     */
    protected static function extractCapabilityNameFromMethodName($methodName){
        $methodPrefixLength = strlen(static::$capabilityMethodPrefix);
        return lcfirst(substr($methodName, $methodPrefixLength));
    }
    
}