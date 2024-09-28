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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories',
            'icon' => 'required',
            'icon' => 'image',
        ]);

        if ($validator->fails()) {
            $validator->errors()->all();
        }

        $image =  $request->image;
        $extension = $image->extension();
        $file_name = random_int(10000, 50000) . '.' . $extension;

        Image::make($image)->save(public_path('images/category/' . $file_name));

        $category = Category::create([
            'category_name' => $request->category_name,
            'image' => $image,
            'created_at' => Carbon::now(),
        ]);

        $response = [
            'category' => $category,
            'message' => 'Category Added Successfull!',
        ];

        return response()->json($response);
    }
}
