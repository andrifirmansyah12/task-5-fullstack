<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::join('users', 'categories.user_id', '=', 'users.id')
            ->where('categories.user_id', '=', Auth::user()->id)
            ->get(['categories.*', 'users.name']);
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'name_category' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            return response()->json($response, 400);
        }

        $categories = new Category();
        $categories->name_category = $request->name_category;
        $categories->user_id = Auth::user()->id;
        $categories->save();

        $response = [
            'success' => true,
            'data' => $categories,
            'message' => 'Category successfully added!'
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'name_category' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            return response()->json($response, 400);
        }

        $categories = Category::find($id);
        $categories->name_category = $request->name_category;
        $categories->save();

        $response = [
            'success' => true,
            'data' => $categories,
            'message' => 'Category successfully updated!'
        ];

        return response()->json($response, 200);
    }

    public function destroy($id)
    {
        $categories = Category::findOrFail($id);
        $categories->delete();

        $response = [
            'success' => true,
            'message' => 'Category successfully deleted!'
        ];

        return response()->json($response, 200);
    }
}
