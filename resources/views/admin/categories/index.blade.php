{{-- This view is deprecated - routes now point directly to Livewire component --}}
{{-- Kept for backward compatibility only --}}
@extends('layouts.admin')

@section('title', 'Manage Categories - Admin')

@section('content')
<livewire:admin.category-management />
@endsection
