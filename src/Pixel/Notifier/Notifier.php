<?php

namespace Pixel\Notifier;

use Pixel\Notifier\AbstractNotifier;

/**
 * Class Notifier
 * @package Pixel\Notifier
 */
class Notifier
{
    /**
     * @var AbstractNotifier[] $providers
     */
    protected $providers;

    /**
     * Notifier constructor.
     * @param array AbstractNotifier[] $providers
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
