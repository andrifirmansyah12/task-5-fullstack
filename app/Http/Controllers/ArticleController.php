<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Validator;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::join('users', 'articles.user_id', '=', 'users.id')
                ->join('categories', 'articles.category_id', '=', 'categories.id')
                ->where('articles.user_id', '=', Auth::user()->id)
                ->get(['articles.*', 'users.name', 'categories.name_category']);
        return response()->json($articles);
    }

    public function store(Request $request)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            // 'image' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            return response()->json($response, 400);
        }

        $articles = new Article();

        if ($request->image == null) {
            $articles->title = $request->title;
            $articles->content = $request->content;
            $articles->category_id = $request->category_id;
            $articles->user_id = Auth::user()->id;
            $articles->save();
        } else {
            $imageName = time().".".$request->image->getClientOriginalExtension();

            $articles->title = $request->title;
            $articles->content = $request->content;
            $articles->category_id = $request->category_id;
            $articles->user_id = Auth::user()->id;
            $articles->image = $imageName;
            $articles->save();

            $request->image->move(public_path('img'), $imageName);
        }

        $response = [
            'success' => true,
            'data' => $articles,
            'message' => 'Article successfully added!'
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            return response()->json($response, 400);
        }

        $articles = Article::find($id);

        if ($request->image == $articles->image) {
            $articles->title = $request->title;
            $articles->content = $request->content;
            $articles->category_id = $request->category_id;
            $articles->user_id = Auth::user()->id;
            $articles->save();
        } else if (is_string($request->image)) {
            $articles->title = $request->title;
            $articles->content = $request->content;
            $articles->category_id = $request->category_id;
            $articles->user_id = Auth::user()->id;
            $articles->image = null;
            $articles->save();
        } else {
            $imageName = time().".".$request->image->getClientOriginalExtension();

            $path = public_path('img');
            if (!empty($articles->image) && file_exists($path.'/'.$articles->image)) {
                unlink($path.'/'.$articles->image);
            }

            $articles->title = $request->title;
            $articles->content = $request->content;
            $articles->category_id = $request->category_id;
            $articles->user_id = Auth::user()->id;
            $articles->image = $imageName;
            $articles->save();

            $request->image->move(public_path('img'), $imageName);
        }

        $response = [
            'success' => true,
            'data' => $articles,
            'message' => 'Category successfully updated!'
        ];

        return response()->json($response, 200);
    }

    public function destroy($id)
    {
        $articles = Article::findOrFail($id);
        $articles->delete();

        $currentImage = $articles->image;

        $articleImage = public_path('img/').$currentImage;

        if(file_exists($articleImage)) {

            @unlink($articleImage);

        }

        $response = [
            'success' => true,
            'message' => 'Category successfully deleted!'
        ];

        return response()->json($response, 200);
    }
}
