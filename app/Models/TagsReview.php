<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagsReview extends Model
{
    protected $table = 'tags_review';
    protected $fillable = [
        'userId',
        'reviewId',
        'tags',
    ];
    public function review(){
        return $this->belongsTo(Review::class,'reviewId','id');
    }
    public function tagsReview(){
        return $this->hasOne(Tags::class,'id','tags')->select(['id','tagsName']);
    }
}
