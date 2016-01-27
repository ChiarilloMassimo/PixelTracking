<?php

namespace Pixel\Notifier;

use Pixel\Notifier\AbstractNotifier;

/**
 * Class Notifier
 * @package Pixel\Notifier
 */
class Notifier
{
    protected $providers;

    /**
     * Notifier constructor.
     * @param array $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    /**
     * @param $message
     */
    public function notify($message)
    {
        foreach($this->providers as $provider) {
            $provider->notify($message);
        }
    }
}
