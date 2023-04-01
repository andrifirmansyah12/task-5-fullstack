<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Validator;

class PostController extends Controller
{
    public function index()
    {
        $articles = Article::all()->paginate(6);
        return response()->json([
            "success" => true,
            "message" => "Product List",
            "data" => $articles
        ]);
    }

    public function store(Request $request)
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

        $articles = new Article();

        if ($request->image == null) {
            $articles->title = $request->title;
            $articles->content = $request->content;
            $articles->category_id = $request->category_id;
            $articles->user_id = "Auth::user()->id";
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
            'message' => 'Article successfully added!',
            'data' => $articles
        ];

        return response()->json($response, 200);
    }

    public function show($id)
    {
        $articles = Article::find($id);
        if (is_null($articles)) {
            return $this->sendError('Article not found!');
        }
        return response()->json([
            'success' => true,
            'message' => 'Article retrieved successfully!',
            'data' => $articles
        ]);
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
            'message' => 'Category successfully updated!',
            'data' => $articles
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
            'message' => 'Category successfully deleted!',
            'data' => $articles
        ];

        return response()->json($response, 200);
    }
}
