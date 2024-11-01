<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Color;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductFormRequest;
use App\Models\ProductColor;
use App\Models\SubCategory;

class ProductController extends Controller
{
    public function index()
    {
        $products=Product::all();
        return view('admin.products.index',compact('products'));
    }
    public function create()
    {
        $sub_categories=SubCategory::all();
        $brands=Brand::all();
        $colors=Color::where('status','0')->get();
        return view('admin.products.create',compact('sub_categories','brands','colors'));
    }
    public function store(ProductFormRequest $request){
        $validatedDate=$request->validated();
        $sub_category=SubCategory::findOrFail($validatedDate['sub_category_id']);
        
        $product=$sub_category->products()->create([
            'sub_category_id'=>$validatedDate['sub_category_id'],
            'name'=>$validatedDate['name'],
            'slug'=>Str::slug($validatedDate['slug']),
            'brand'=>$validatedDate['brand'],
            'small_description'=>$validatedDate['small_description'],
            'description'=>$validatedDate['description'],
            'original_price'=>$validatedDate['original_price'],
            'selling_price'=>$validatedDate['selling_price'],
            'quantity'=>$validatedDate['quantity'],
            'trending'=>$request->trending==true ?'1':'0',
            'featured'=>$request->featured==true ?'1':'0',
            'status'=>$request->status==true ?'1':'0',
            'meta_title'=>$validatedDate['meta_title'],
            'meta_keyword'=>$validatedDate['meta_keyword'],
            'meta_description'=>$validatedDate['meta_description'],
        ]);
        if($request->hasFile('image')){
            $uploadPath='uploads/products/';
            $i=1;
            foreach($request->file('image')as $imageFile){
                $extention=$imageFile->getClientOriginalExtension();
                $filename=time().$i++.'.'.$extention;
                $imageFile->move($uploadPath,$filename);
                $finalImagePathName=$uploadPath.$filename;

                $product->productImages()->create([
                'product_id'=>$product->id,
                'image'=>$finalImagePathName,
                ]);
            }
        }
        if($request->colors)
        {
            foreach($request->colors as $key=>$color){
                $product->productColors()->create([
                    'product_id'=>$product->id,
                    'color_id'=>$color,
                    'quantity'=>$request->colorquantity[$key] ?? 0
                ]);
            }
        }
        return redirect('/admin/products')->with('message','Product Added Successfully');
        // return $product->id;
    }
    public function edit(int $product_id)
    {
        $sub_categories=SubCategory::all();
        $brands=Brand::all();
        $product=Product::findOrFail($product_id);
        $product_color=$product->productColors->pluck('color_id')->toArray();
        // dd($product_color);
        $colors=Color::whereNotIn('id',$product_color)->get();
        // dd($colors);
        return view('admin.products.edit',compact('sub_categories','brands','product','colors'));
    }
    public function update(ProductFormRequest $request,int $product_id)
    {
        $validatedDate=$request->validated();
        $product=SubCategory::findOrFail($validatedDate['sub_category_id'])
                ->products()->where('id',$product_id)->first();
        if($product){
            $product->update([
            'sub_category_id'=>$validatedDate['sub_category_id'],
            'name'=>$validatedDate['name'],
            'slug'=>Str::slug($validatedDate['slug']),
            'brand'=>$validatedDate['brand'],
            'small_description'=>$validatedDate['small_description'],
            'description'=>$validatedDate['description'],
            'original_price'=>$validatedDate['original_price'],
            'selling_price'=>$validatedDate['selling_price'],
            'quantity'=>$validatedDate['quantity'],
            'trending'=>$request->trending==true ?'1':'0',
            'featured'=>$request->featured==true ?'1':'0',
            'status'=>$request->status==true ?'1':'0',
            'meta_title'=>$validatedDate['meta_title'],
            'meta_keyword'=>$validatedDate['meta_keyword'],
            'meta_description'=>$validatedDate['meta_description'],
        ]);
        if($request->hasFile('image')){
            $uploadPath='uploads/products/';
            $i=1;
            foreach($request->file('image')as $imageFile){
                $extention=$imageFile->getClientOriginalExtension();
                $filename=time().$i++.'.'.$extention;
                $imageFile->move($uploadPath,$filename);
                $finalImagePathName=$uploadPath.$filename;

                $product->productImages()->create([
                'product_id'=>$product->id,
                'image'=>$finalImagePathName,
                ]);
            }
        }
        if($request->colors)
        {
            foreach($request->colors as $key=>$color){
                $product->productColors()->create([
                    'product_id'=>$product->id,
                    'color_id'=>$color,
                    'quantity'=>$request->colorquantity[$key] ?? 0
                ]);
            }
        }
        return redirect('/admin/products')->with('message','Product Updated Successfully');
        }else{
            return redirect('admin/products')->with('message','No Such Product Id Found');
        }
    }
    public function destroyImage(int $product_image_id)
    {
        $productImage=ProductImage::findOrFail($product_image_id);
        if(File::exists($productImage->image)){
            File::delete($productImage->image);
        }
        $productImage->delete();
        return redirect()->back()->with('message','Product Image Deleted');    
    }
    public function destroy(int $product_id){
        $product=Product::findOrFail($product_id);
        if($product->productImages){
            foreach($product->productImages as $image){
                if(File::exists($image->image)){
                    File::delete($image->image);
                }
            }
        }
        $product->delete();
        return redirect()->back()->with('message','Product Deleted with all its image');
    }
    public function updateProdColorQty(Request $request,$prod_color_id)
    {
        $productColorData=Product::findOrFail($request->product_id)
                            ->productColors()->where('id',$prod_color_id)->first();
        $productColorData->update([
            'quantity'=>$request->qty
        ]);
        return response()->json(['message'=>'Product Color Qty updated']);
        
    }
    public function deleteProdColor($prod_color_id)
    {
        $prodColor=ProductColor::findOrFail($prod_color_id);
        $prodColor->delete();
        return response()->json(['message'=>'Product Color Deleted']);
        
    }
}
