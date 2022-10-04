<?php

namespace Konnco\SatSet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PushNotificationToken extends Model
{
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
