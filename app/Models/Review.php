<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    protected $fillable = [
        'ASIN',
        'title',
        'body',
        'reviewUrl',
        'verif',
        'rating',
        'author',
        'authorUrl',
        'reviewDate',
        'comment',
        'isVideo',
        'isImage'
    ];

    public function scopeFilterStar($query,$data){
        $filter = json_decode($data);
        $query->whereIn('rating',$filter);
        return $query;
    }
    public function scopeFilterVerif($query,$data){
        $query->where('verif',$data);
        return $query;
    }
}
