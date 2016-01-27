<?php

namespace Pixel\Notifier\Providers;

use Sly\PushOver\Model\Push;
use Sly\PushOver\PushManager;

class PushOver extends AbstractNotifier
{
    /**
     * @var
     */
    protected $pushManager;

    /**
     * PushOver constructor.
     * @param $userKey
     * @param $appKey
     */
    public function __construct($userKey, $appKey)
    {
        $this->pushManager = new PushManager($userKey, $appKey);
    }

    /**
     * @param $message
     */
    public function notify($message)
    {
        $push = new Push();
        $push->setTitle(APP_NAME);
        $push->setMessage($message);

        $this->pushManager->push($push);
    }
}
