<?php

namespace Konnco\SatSet\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens;

    protected $guarded = [];
}
