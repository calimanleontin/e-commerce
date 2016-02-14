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

    public function delete(Request $request, $id)
    {
        $user = $request->user();
        $comment = Comments::where('id',$id)->first();

        if($user->is_admin() or $user->is_moderator() or $user->id == $comment->author) {
            $product = Products::where('id',$comment->on_product)->first();

            $comment->delete();
            return redirect('/product/' . $product->slug)->withMessage('Comment deleted successfully');
        }
        else
            return redirect('/')->withErrors('You have not sufficient permissions');
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function edit(Request $request, $id)
    {
        $comment = Comments::where('id',$id)->first();
        $user = $request->user();
        if($user->is_admin() or $user->is_moderator() or $user->id == $comment->author_id) {
            return view('comment.edit')->withComment($comment);
        }
        else
            redirect ('/')->withErrors('You have not sufficient permissions');

    }

    /**
     * @param Request $request
     * @param $comment_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $comment_id = $request->input('comment_id');
        $comment = Comments::where('id',$comment_id)->first();
        $user = $request->user();
        if($user->is_admin() or $user->is_moderator() or $user->id == $comment->author_id) {
            $content = $request->input('content');

            $comment->content = $content;
            $comment->save();

            $product = Products::where('id', $comment->on_product)->first();
            return redirect('/product/' . $product->slug);
        }
        else
            redirect ('/')->withErrors('You have not sufficient permissions');
    }
}
