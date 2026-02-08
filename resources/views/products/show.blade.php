@extends('layouts.app')

@section('title', $product->name . ' - E-Mart')

@section('content')
<livewire:products.product-detail :productId="$product->id" />
@endsection
