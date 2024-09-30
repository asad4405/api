<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CategoryApiController extends Controller
{
    public function index()
    {
        // $categories = Category::select('category_name','image')->get();
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories',
            'image' => 'required',
            'image' => 'image',
        ]);

        if ($validator->fails()) {
            $validator->errors()->all();
        }

        // image
        $image = $request->file('image');
        $imageName = 'category-'. time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/category'), $imageName);
        $file_name = 'images/category/' . $imageName;

        // Image::make($image)->save(public_path('images/category/' . $file_name));

        $category = Category::create([
            'category_name' => $request->category_name,
            'image' => $file_name,
            'created_at' => Carbon::now(),
        ]);

        $response = [
            'category' => $category,
            'message' => 'Category Added Successfull!',
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        if (!$category) {
            $response = [
                'message' => 'No Data Found!',
            ];
        }
        $response = [
            'category' => $category,
        ];
        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        if ($request->image == '') {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|unique:categories',
            ]);

            if ($validator->fails()) {
                $validator->errors()->all();
            }

            $category = Category::find($id)->update([
                'category_name' => $request->category_name,
            ]);

            $response = [
                'category' => $category,
                'message' => 'Category Update Success!'
            ];

            return response()->json($response);
        } else {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|unique:categories',
                'image' => 'required',
                'image' => 'image',
            ]);

            if ($validator->fails()) {
                $validator->errors()->all();
            }

            $category = Category::find($id);
            $del_img = public_path('uploads/category/' . $category->image);
            unlink($del_img);

            $image =  $request->image;
            $extension = $image->extension();
            $file_name = Str::lower(str_replace(' ', '-', $request->category_name)) . random_int(10000, 50000) . '.' . $extension;

            Image::make($image)->save(public_path('uploads/category/' . $file_name));

            $category = Category::find($id)->update([
                'category_name' => $request->category_name,
                'image' => $file_name,
                'created_at' => Carbon::now(),
            ]);

            $response = [
                'category' => $category,
                'message' => 'Category Update Success!',
            ];

            return response()->json($response);
        }
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);

        $del_img = public_path('images/category/' . $category->image);
        unlink($del_img);

        $category->delete();

        $response = [
            'message' => 'Category Deleted Success!'
        ];
        return response()->json($response);
    }
}
