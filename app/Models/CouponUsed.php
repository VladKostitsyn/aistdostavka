<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class CouponUsed extends Model
{
    public $table = 'coupon_used';

    protected $fillable = [
        'id',
        'user_id',
        'coupon_id'
    ];
    public function User()
    {
        return $this->hasMany(\App\Models\User::class, 'id','user_id');
    }
    public function Coupon()
    {
        return $this->hasMany(\App\Models\Coupon::class, 'id','coupon_id');
    }

}
