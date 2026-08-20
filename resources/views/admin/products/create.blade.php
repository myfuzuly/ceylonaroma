@extends('layouts.admin')
@section('title', 'New Product')
@section('breadcrumb')
    <a href="{{ route('admin.products.index') }}" style="color:var(--a-muted)">Products</a>
    <span style="margin:0 .5rem;color:var(--a-muted)">/</span>
    <span>New</span>
@endsection

@section('content')
<div class="page-title">Add Product</div>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.products._fields')
</form>
@endsection
