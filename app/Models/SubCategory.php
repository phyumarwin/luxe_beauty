<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;

    protected $table='sub_categories';

    protected $fillable=[
        'name',
        'category_id',
        'slug',
        'description',
        'image',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'status',
    ];
    public function products(){
        return $this->hasMany(Product::class,'sub_category_id','id');
    }
    public function relatedProducts(){
        return $this->hasMany(Product::class,'sub_category_id','id')->latest()->take(16);
    }
    public function brands(){
        return $this->hasMany(Brand::class,'sub_category_id','id')->where('status','0');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
