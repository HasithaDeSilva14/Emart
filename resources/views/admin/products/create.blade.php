{{-- This view is deprecated - routes now point directly to Livewire component --}}
{{-- Kept for backward compatibility only --}}
@extends('layouts.admin')

@section('title', 'Add Product - Admin')

@section('content')
<livewire:admin.product-form />
@endsection
