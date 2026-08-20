@extends('layouts.admin')
@section('title', 'Edit Product')
@section('breadcrumb')
    <a href="{{ route('admin.products.index') }}" style="color:var(--a-muted)">Products</a>
    <span style="margin:0 .5rem;color:var(--a-muted)">/</span>
    <span>Edit</span>
@endsection

@section('content')
<div class="page-title">Edit Product</div>
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.products._fields')
</form>
@endsection
