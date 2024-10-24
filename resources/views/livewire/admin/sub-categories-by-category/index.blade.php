<div>
    <!-- Display all categories -->
    <div class="categories">
        <h4>Select Category:</h4>
        <ul>
            @foreach($categories as $category)
                <li>
                    <a href="#" wire:click.prevent="loadSubcategories({{ $category->id }})">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Display related subcategories when a category is selected -->
    @if($selectedCategory)
        <div class="subcategories mt-4">
            <h5>Subcategories:</h5>
            <ul>
                @forelse($subcategories as $subcategory)
                    <li>{{ $subcategory->name }}</li>
                @empty
                    <li>No subcategories found for this category.</li>
                @endforelse
            </ul>
        </div>
    @endif
</div>
