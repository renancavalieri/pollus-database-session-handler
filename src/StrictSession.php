<?php

/**
 * Database Session Handler
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\DatabaseSessionHandler;

use Pollus\DatabaseSessionHandler\DatabaseSessionHandler;
use Pollus\ImprovedSession\ImprovedSession;
use Pollus\SessionWrapper\SessionInterface;

class StrictSession extends ImprovedSession implements SessionInterface
{
    /**
     * @var array
     */
    protected $settings;
    
    /**
     * @var DatabaseSessionHandler
     */
    protected $handler;
    
    /**
     * @param string $name
     * @param DatabaseSessionHandler $handler
     * @param array $settings
     */
    public function __construct(DatabaseSessionHandler $handler, array $settings = [])
    {
        parent::__construct($settings);
        $this->handler = $handler;
        $this->handler->register();
    }
    
    /**
     * Starts a session
     * 
     * @return void
     */
    public function start(array $options = []) : bool
    {
        parent::start($options);    
        if($this->handler->ValidateOnce($this->id()) === false)
        {
            $this->regenerateId(true);
        }
        return true;
    }
}
