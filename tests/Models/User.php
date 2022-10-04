<?php

namespace Konnco\SatSet\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Konnco\SatSet\Models\Concerns\HasPushNotificationToken;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens;
    use HasPushNotificationToken;

    protected $guarded = [];
}
