<?php

namespace App\Http\Livewire\Admin\SubCategory;

use Livewire\Component;
use App\Models\SubCategory;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sub_category_id;
    public function deleteSubCategory($sub_category_id){
        $this->sub_category_id=$sub_category_id;
    }
    public function destroyCategory(){
        $sub_category=SubCategory::find($this->sub_category_id);
        $path='uploads/sub_category/'.$sub_category->image;
        if(File::exists($path)){
            File::delete($path);
        }
        $sub_category->delete();
        session()->flash('message','SubCategory Deleted');
        $this->dispatchBrowserEvent('close-modal');
    }
    public function render()
    {
        $sub_categories=SubCategory::orderBy('id','DESC')->paginate(10);
        return view('livewire.admin.sub-category.index',['sub_categories'=>$sub_categories]);
    }
}
