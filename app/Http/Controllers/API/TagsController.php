<?php

namespace App\Http\Controllers\API;

use App\Models\Tags;
use App\Models\TagsReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
    public function insertTags(Request $request,$reviewId){
        $userId = Auth::id();
        $tags = Tags::where('tagsName',$request['tagsName'])
            ->where('userId',$userId)
            ->first();
        if(!$tags){
            $tags = Tags::create([
                'userId' => $userId,
                'tagsName' => $request['tagsName'],
            ]);
        }
        $checkTags = TagsReview::where('tags',$tags['id'])
            ->where('reviewId',$reviewId)
            ->first();
        if(!empty($checkTags)){
            return $this->ErrorHandlers('tags exist');
        }
        TagsReview::create([
            'userId' => $userId,
            'reviewId' => $reviewId,
            'tags' => $tags['id'],
        ]);
        return $this->SuksesHandlers(null);
    }

    public function deleteTagsReview($id){
        $userId = Auth::id();
        TagsReview::where('id',$id)
            ->where('userId',$userId)
            ->delete();
        return $this->SuksesHandlers(null);
    }

    public function deleteTags($id){
        $userId = Auth::id();
        Tags::where('id',$id)
            ->where('userId',$userId)
            ->delete();
        TagsReview::where('tags',$id)
            ->where('userId',$userId)
            ->delete();
        return $this->SuksesHandlers(null);
    }
    public function getTagsReview($reviewId){
        $userId = Auth::id();
        $data = TagsReview::where('reviewId',$reviewId)
            ->where('userId',$userId)
            ->with('tagsReview')
            ->get();
        return $data;
    }
}
