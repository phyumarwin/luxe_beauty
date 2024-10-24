@extends('layouts.app')

@section('title')
    {{ $sub_category->meta_title }}
@endsection

@section('meta_keyword')
    {{ $sub_category->meta_keyword }}
@endsection

@section('meta_description')
    {{ $sub_category->meta_description }}
@endsection

@section('content')
<div class="py-3 py-md-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-4">Our Products</h4>
            </div>

            <livewire:frontend.product.index :sub_category="$sub_category" />
        </div>
    </div>
</div>
@endsection
