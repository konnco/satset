<?php

namespace Konnco\SatSet\Http\Controllers\Auth\Login\Concerns;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait CanRegisterPushNotificationToken
{
    protected bool $shouldRegisterPushNotificationToken = true;

    public function getNotificationTokenParameterName()
    {
        return 'notification_token';
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function registerPushNotification()
    {
        if (! $this->shouldRegisterPushNotificationToken) {
            return;
        }

        if (! method_exists($this->user(), 'pushNotificationToken')) {
            return;
        }

        if (! request()->filled($this->getNotificationTokenParameterName())) {
            return;
        }

        $this->user()
            ->pushNotificationToken(
                request()->get($this->getNotificationTokenParameterName())
            );
    }
}
