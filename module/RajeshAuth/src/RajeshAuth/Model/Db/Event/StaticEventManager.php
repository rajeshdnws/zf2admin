<?php

namespace RajeshAuth\Model\Event;

use Zend\EventManager\SharedEventManager;
use Zend\EventManager\SharedEventManagerInterface;

/**
 * Static version of EventManager
 *
 * @category   Gc
 * @package    Library
 * @subpackage Event
 */
class StaticEventManager extends SharedEventManager
{
    /**
     * Retrieve StaticEventManager instance
     *
     * @var SharedEventManagerInterface
     */
    protected static $instance;

    /**
     * Retrieve instance
     *
     * @return SharedEventManagerInterface
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::setInstance(new static());
        }

        return static::$instance;
    }

    /**
     * Set the singleton to a specific SharedEventManagerInterface instance
     *
     * @param SharedEventManagerInterface $instance Event instance
     *
     * @return void
     */
    public static function setInstance(SharedEventManagerInterface $instance)
    {
        static::$instance = $instance;
    }

    /**
     * Is a singleton instance defined?
     *
     * @return bool
     */
    public static function hasInstance()
    {
        return (static::$instance instanceof SharedEventManagerInterface);
    }

    /**
     * Reset the singleton instance
     *
     * @return void
     */
    public static function resetInstance()
    {
        static::$instance = null;
    }

    /**
     * Retrieve event
     *
     * @param string $id Id
     *
     * @return \Zend\EventManager\EventManager
     */
    public function getEvent($id)
    {
        if (!array_key_exists($id, $this->identifiers)) {
            return false;
        }

        return $this->identifiers[$id];
    }

    /**
     * Trigger all listeners for a given event
     *
     * Can emulate triggerUntil() if the last argument provided is a callback.
     *
     * @param string            $id       Identifier(s) for event emitting component(s)
     * @param string            $event    Event
     * @param string|object     $target   Object calling emit, or symbol describing target (such as static method name)
     * @param array|ArrayAccess $argv     Array of arguments; typically, should be associative
     * @param null|callable     $callback Callback function
     *
     * @return \Zend\EventManager\ResponseCollection All listener return values
     * @throws \Zend\EventManager\Exception\InvalidCallbackException
     */
    public function trigger($id, $event, $target = null, $argv = array(), $callback = null)
    {
        $e = $this->getEvent($id);
        if (empty($e)) {
            return false;
        }

        return $e->trigger($event, $target, $argv, $callback);
    }
}
