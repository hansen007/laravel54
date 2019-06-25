<?php

namespace App;

use App\Model;

class Fan extends Model
{
    // 获取粉丝用户信息
    public function fuser()
    {
        return $this->hasOne(\App\User::class, 'id', 'fan_id');
    }

    // 获取关注用户信息
    public function suser()
    {
        return $this->hasOne(\App\User::class, 'id', 'star_id');
    }
}
