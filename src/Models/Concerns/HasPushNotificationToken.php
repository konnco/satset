<?php

namespace Konnco\SatSet\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Konnco\SatSet\Models\PushNotificationToken;

/**
 * @mixin Model
 */
trait HasPushNotificationToken
{
    public function pushNotifications(): MorphMany
    {
        return $this->morphMany(PushNotificationToken::class, 'notifiable');
    }

    public function pushNotificationToken($token): static
    {
        $pushToken = new PushNotificationToken();
        $pushToken->token = $token;
        $pushToken->notifiable_type = self::class;
        $pushToken->notifiable_id = $this->id;
        $pushToken->save();

        $this->pushNotifications()->save($pushToken);

        return $this;
    }

    public function getPushNotificationTokens(): Collection
    {
        return $this
            ->pushNotifications()
            ->pluck('token');
    }
}
