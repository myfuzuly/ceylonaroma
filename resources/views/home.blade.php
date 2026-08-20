@extends('layouts.app')

@section('title', 'Home')

@section('content')
@include('home-p1')
@include('home-p2')
@include('home-p3')
@endsection

@push('scripts')
<script>
document.querySelectorAll('.tab-btn[data-tab]').forEach(btn=>{
    btn.addEventListener('click',()=>{
        document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
    });
});
</script>
@endpush
