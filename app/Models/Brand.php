<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table='brands';
    protected $fillable=['name','slug','status','sub_category_id'];

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }
}
