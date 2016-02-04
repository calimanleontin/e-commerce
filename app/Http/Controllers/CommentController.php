<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Products;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $product_id = $request->input('product_id');
        $content = $request->input('content');
        $comment = new Comments();
        $product = Products::where('id',$product_id)->first();
        $comment->author_id = $request->user()->id;
        $comment->on_product = $product_id;
        $comment->content = $content;
        $comment->save();
        return redirect('/product/'.$product->slug)->withMessage('Comment added');

    }
}
