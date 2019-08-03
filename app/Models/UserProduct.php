<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    protected $table = 'table_user_product';
    protected $fillable = [
        'ASIN',
        'userId',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id','userId');
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'ASIN','ASIN')->select(['ASIN','productName','id','productUrl']);
    }
    public function queue()
    {
        return $this->hasOne(QueueStatus::class, 'ASIN','ASIN')->select(['queueStatus','ASIN']);
    }
}
