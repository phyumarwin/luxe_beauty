@extends('layouts.app')
@section('title','All SubCategories')
@section('content')
<div class="py-3 py-md-5 bg-light">
    {{-- <div class="container"> --}}
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-4">Our SubCategories</h3>
            </div>

            <div class="row row-cols-2 row-cols-md-4 g-4">
                @forelse ($subcategories as $subcategoryItem)
                    <div class="col d-flex justify-content-center">
                        <div class="subcategory-card text-center p-2">
                            <a href="{{ url('/collections/'.$category->slug.'/'.$subcategoryItem->slug) }}">
                                <div class="category-card-img">
                                    <img src="{{ asset($subcategoryItem->image) }}" class="img-fluid w-75 mx-auto d-block" style="border-radius: 100px;" alt="{{ $subcategoryItem->name }}">
                                </div>
                                <div class="subcategory-card-body mt-2">
                                    <h5>{{ $subcategoryItem->name }}</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <h5>No SubCategories Available</h5>
                    </div>
                @endforelse
            </div>
        </div>
    {{-- </div> --}}
</div>
@endsection
