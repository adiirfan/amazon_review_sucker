<?php

namespace App\Http\Controllers\API;

use App\Models\Review;
use App\Models\Tags;
use App\Models\TagsReview;
use App\Models\UserProduct;
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
        $data = TagsReview::create([
            'userId' => $userId,
            'reviewId' => $reviewId,
            'tags' => $tags['id'],
        ]);
        return $this->SuksesHandlers($data);
    }
    public function tagIndex(){
        $userId = Auth::id();
        $data =  Tags::selectRaw('tagsName as text')->where('userId',$userId)->get();
        return $data;

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
    public function analyzeTags(){
        $userId = Auth::id();
        $data =  TagsReview::selectRaw('count(reviewId) as total,tags')->where('userId',$userId)
            ->groupBy('tags')
            ->with('tagsReview')
            ->get();
        return $data;
    }
    public function reviewByTags($tags){
        $page = app('request')->get('page');
        $userId = Auth::id();
        $review = Review::whereHas('tags', function ($query) use($tags,$userId) {
            $query->where('tags',$tags)
                ->where('userId',$userId);
        })->with('product');
        return $review->orderBy('id', 'ASC')->paginate(
            $limit ?? 10,
            ['*'],
            'page',
            $page ?? 1
        );

    }
}
