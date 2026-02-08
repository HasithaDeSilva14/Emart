{{-- This view is deprecated - routes now point directly to Livewire component --}}
{{-- Kept for backward compatibility only --}}
@extends('layouts.admin')

@section('title', 'Edit Product - Admin')

@section('content')
<livewire:admin.product-form :product="$product" />
@endsection
