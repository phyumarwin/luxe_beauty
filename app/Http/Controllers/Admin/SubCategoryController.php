<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\SubCategoryFormRequest;

class SubCategoryController extends Controller
{
    public function index()
    {
        return view('admin.subcategory.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategory.create', compact('categories'));
    }

    public function store(SubCategoryFormRequest $request)
    {
        // dd($request->all());
        $validatedData=$request->validated();
        $sub_category=new SubCategory();
        $sub_category->name=$validatedData['name'];
        $sub_category->category_id=$validatedData['category_id'];
        $sub_category->slug=Str::slug($validatedData['slug']);
        $sub_category->description=$validatedData['description'];

        $uploadPath='uploads/sub_category/';
        if($request->hasFile('image')){
            $file=$request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;
            $file->move('uploads/sub_category/',$filename);
            $sub_category->image=$uploadPath.$filename;
        }

        $sub_category->meta_title=$validatedData['meta_title'];
        $sub_category->meta_keyword=$validatedData['meta_keyword'];
        $sub_category->meta_description=$validatedData['meta_description'];

        $sub_category->status=$request->status==true ? '1':'0';
        // dd($sub_category->image);
        $sub_category->save();
        return redirect('admin/sub_category')->with('message','SubCategory Added Successfully');
    }

    public function edit(SubCategory $sub_category)
    {
        $categories = Category::all();
        return view('admin.subcategory.edit', compact('sub_category', 'categories'));
    }

    public function update(SubCategoryFormRequest $request,$sub_category)
    {
        $validatedData=$request->validated();
        $sub_category=SubCategory::findOrFail($sub_category);

        $sub_category->name=$validatedData['name'];
        $sub_category->category_id=$validatedData['category_id'];
        $sub_category->slug=Str::slug($validatedData['slug']);
        $sub_category->description=$validatedData['description'];

        if($request->hasFile('image')){
            $uploadPath='uploads/sub_category/';
            $path=public_path('uploads/sub_category/'.$sub_category->image);
            if(File::exists($path)){
                File::delete($path);
            }
            $file=$request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;
            $file->move('uploads/sub_category/',$filename);
            $sub_category->image=$uploadPath.$filename;
        }

        $sub_category->meta_title=$validatedData['meta_title'];
        $sub_category->meta_keyword=$validatedData['meta_keyword'];
        $sub_category->meta_description=$validatedData['meta_description'];

        $sub_category->status=$request->status==true ? '1':'0';
        $sub_category->update();
        return redirect('admin/sub_category')->with('message','SubCategory Updated Successfully');
    }
}
