<?php

namespace App\Http\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $category_id;
    public $subcategories = [];
    public function deleteCategory($category_id){
        // dd($category_id);
        $this->category_id=$category_id;
    }
    public function destroyCategory(){
        $category=Category::find($this->category_id);
        $path='uploads/category/'.$category->image;
        if(File::exists($path)){
            File::delete($path);
        }
        $category->delete();
        session()->flash('message','Category Deleted');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function updatedCategoryId()
    {
        $this->fetchSubcategories();
    }

    public function fetchSubcategories()
    {
        if ($this->category_id) {
            $this->subcategories = SubCategory::where('category_id', $this->category_id)->get();
        } else {
            $this->subcategories = [];
        }
    }

    public function render()
    {
        $categories=Category::orderBy('id','DESC')->paginate(10);
        return view('livewire.admin.category.index',['categories'=>$categories,'subcategories' => $this->subcategories]);
    }
}
