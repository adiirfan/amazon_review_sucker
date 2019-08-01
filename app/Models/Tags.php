<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'Tags';
    protected $fillable = [
        'userId',
        'tagsName',
    ];

    public function TagsReview(){
        return $this->hasOne(TagsReview::class,'tags','id');
    }
}
