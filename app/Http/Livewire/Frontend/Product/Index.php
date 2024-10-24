<?php
namespace App\Http\Livewire\Frontend\Product;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public $products, $sub_category, $brandInputs = [], $priceInput;

    protected $queryString = [
        'brandInputs' => ['except' => '', 'as' => 'brand'],
        'priceInput' => ['except' => '', 'as' => 'price'],
    ];

    public function mount($sub_category)
    {
        $this->sub_category = $sub_category; // Assign the sub_category parameter
    }

    public function render()
    {
        $this->products = Product::where('sub_category_id', $this->sub_category->id)
            ->when($this->brandInputs, function ($q) {
                $q->whereIn('brand', $this->brandInputs);
            })
            ->when($this->priceInput, function ($q) {
                $q->when($this->priceInput == 'high-to-low', function ($q2) {
                    $q2->orderBy('selling_price', 'DESC');
                })
                ->when($this->priceInput == 'low-to-high', function ($q2) {
                    $q2->orderBy('selling_price', 'ASC');
                });
            })
            ->where('status', '0')->get();

        return view('livewire.frontend.product.index', [
            'products' => $this->products,
            'sub_category' => $this->sub_category
        ]);
    }
}
