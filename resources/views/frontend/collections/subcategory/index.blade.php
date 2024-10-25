@extends('layouts.app')
@section('title','All SubCategories')
@section('content')
<div class="py-3 py-md-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-4">Our SubCategories</h4>
            </div>

            @forelse ($subcategories as $subcategoryItem)
                <div class="col-6 col-md-3">
                    <div class="subcategory-card">
                        <a href="{{ url('/collections/'.$category->slug) }}">
                            <div class="category-card-img">
                                <img src="{{ asset($subcategoryItem->image) }}" class="w-100" alt="{{ $subcategoryItem->name }}">
                            </div>
                            <div class="subcategory-card-body">
                                <h5>{{ $subcategoryItem->name }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <h5>No SubCategories Available</h5>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
