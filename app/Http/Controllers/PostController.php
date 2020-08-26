<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function getDashboard()
    {
        $posts=Post::orderBy('created_at','desc')->get();
        return view('dashboard',['posts'=>$posts]);
    }
    public function createPost(Request $request)
    {
        // some validation
        $this->validate($request,[
           'body'=>'required|max:1500'
        ]);
        $post=new Post();
        $post->body= $request['body'];
        $message='There was an error';
        if ($request->user()->posts()->save($post))
        {
            $message='Your idea has successfully posted :)';
        }
        return redirect()->route('dashboard')->with(['message'=>$message]);
    }

    public function deletePost($post_id)
    {
        $post=Post::where('id',$post_id)->first();
        if(Auth::user()!= $post->user)
        {
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message'=>'successfully deleted  ']);
    }

    public function editpost(Request $request)
    {
        $this->validate($request,[
           'body'=>'required'
        ]);
        $post = Post::find($request['postId']);
        if(Auth::user()!= $post->user)
        {
            return redirect()->back();
        }
        $post->body =$request['body'];
        $post->update();
        return response()->json(['new-body'=>$post->body],200);
    }

    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $post = Post::find($post_id);
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        $like = Like::where('user_id', $user->id)->where( 'post_id', $post_id)->first();
        if ($like) {
            $already_like = $like->like;
            $update = true;
            if ($already_like == $is_like) {
                $like->delete();
                $likeCount = Like::where('post_id', $post_id)->where('like', 1)->count();
                $dislikeCount = Like::where('post_id', $post_id)->where('like', 0)->count();
                return response()->json(['likeCount' => $likeCount, 'dislikeCount' => $dislikeCount], 200);
            }
            else{
                $like->like = $is_like;
                $like->save();
                $likeCount = Like::where('post_id', $post_id)->where('like', 1)->count();
                $dislikeCount = Like::where('post_id', $post_id)->where('like', 0)->count();
                return response()->json(['likeCount' => $likeCount, 'dislikeCount' => $dislikeCount], 200);
            }
        }
        $like = new Like();
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        $like->save();

        $likeCount = Like::where('post_id', $post_id)->where('like', 1)->count();
        $dislikeCount = Like::where('post_id', $post_id)->where('like', 0)->count();
        return response()->json(['likeCount' => $likeCount, 'dislikeCount' => $dislikeCount], 200);
    }
}
