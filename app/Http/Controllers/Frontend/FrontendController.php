<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function index()
    {
        $sliders=Slider::where('status','0')->get();
        $trendingProducts=Product::where('trending','1')->latest()->take(15)->get();
        $newArrivalProducts=Product::latest()->take(16)->get();
        $featuredProducts=Product::where('featured','1')->latest()->take(14)->get();
        return view('frontend.index',compact('sliders','trendingProducts','newArrivalProducts','featuredProducts'));
    }
    public function searchProducts(Request $request)
    {
        // dd('hit');
        if($request->search){
            $searchProducts=Product::where('name','LIKE','%'.$request->search.'%')->latest()->paginate(15);
            return view('frontend.pages.search',compact('searchProducts'));
        }else{
            return redirect()->back()->with('message','Empty Search');
        }
    }
    public function newArrival()
    {
        $newArrivalProducts=Product::latest()->take(16)->get();
        return view('frontend.pages.new-arrival',compact('newArrivalProducts'));
    }
    public function featuredProducts()
    {
        $featuredProducts=Product::where('featured','1')->latest()->get();
        return view('frontend.pages.featured-products',compact('featuredProducts'));
    }
    public function categories()
    {
        $categories=Category::all();
        return view('frontend.collections.category.index',compact('categories'));
    }
    public function products($subcategory_slug)
    {
        $sub_category = SubCategory::where('slug', $subcategory_slug)->first();
        if($sub_category){
            $subcategories = SubCategory::where('category_id', $sub_category->id)->get();            
            return view('frontend.collections.products.index',compact('subcategories'));
        }else{
            return redirect()->back();
        }
    }

    public function subcategoryProducts($category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        if ($category) {
            $subcategories = SubCategory::where('category_id', $category->id)->get();
            return view('frontend.collections.subcategory.index', compact('category', 'subcategories'));
        } else {
            return redirect()->back();
        }
    }
    
    public function productView(string $category_slug,string $product_slug)
    {
        $category=Category::where('slug',$category_slug)->first();
        if($category){
            $product=$category->products()->where('slug',$product_slug)->where('status','0')->first();
            if($product)
            {
                return view('frontend.collections.products.view',compact('product','category'));
            }else{
            return redirect()->back();
        }
        }else{
            return redirect()->back();
        }
    }
    public function thankyou()
    {
        return view('frontend.thank-you');
    }
    public function kpay()
    {
        return view('frontend.kpay');
    }
    
}
