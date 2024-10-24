<?php

namespace App\Http\Livewire\Admin\Brand;

use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme='bootstrap';
    public $name,$slug,$status,$brand_id,$sub_category_id;
    public function rules(){
        return[
            'name'=>'required|string',
            'slug'=>'required|string',
            'sub_category_id'=>'required|integer',
            'status'=>'nullable'
        ];
    }
    public function resetInput(){
        $this->name=NULL;
        $this->slug=NULL;
        $this->status=NULL;
        $this->brand_id=NULL;
        $this->sub_category_id=NULL;
    }
    public function storeBrand(){
        $validatedData=$this->validate();
        Brand::create([
            'name'=>$this->name,
            'slug'=>Str::slug($this->slug),
            'status'=>$this->status == true ? '1':'0',
            'sub_category_id'=>$this->sub_category_id
        ]);
        session()->flash('message','Brand Added Successfully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
    public function closeModal(){
        $this->resetInput();
    }
    public function openModel(){
        $this->resetInput();
    }
    public function editBrand(int $brand_id)
    {
        $this->brand_id=$brand_id;
        $brand=Brand::findOrFail($brand_id);
        $this->name=$brand->name;
        $this->slug=$brand->slug;
        $this->status=$brand->status;
        $this->sub_category_id=$brand->sub_category_id;
    }
    public function updateBrand()
    {
        $validatedData=$this->validate();
        Brand::findOrFail($this->brand_id)->update([
            'name'=>$this->name,
            'slug'=>Str::slug($this->slug),
            'status'=>$this->status == true ? '1':'0',
            'sub_category_id'=>$this->sub_category_id
        ]);
        session()->flash('message','Brand Updated Successfully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
    public function deleteBrand($brand_id)
    {
        $this->brand_id=$brand_id;
    }
    public function destroyBrand()
    {
        Brand::findOrFail($this->brand_id)->delete();
        session()->flash('message','Brand Deleted Successfully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
    public function render()
    {
        $sub_categories=SubCategory::where('status','0')->get();
        $brands=Brand::orderBy('id','DESC')->paginate(10);
        return view('livewire.admin.brand.index',['brands'=>$brands,'sub_categories'=>$sub_categories])
                ->extends('layouts.admin')
                ->section('content');
    }
}
