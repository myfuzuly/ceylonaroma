@extends('layouts.app')
@section('title', 'Quality Assurance')
@section('content')
<div class="simple-page">
    <div class="container">
        <h1>Quality Assurance</h1>
        <p>Every product passes rigorous testing — ISO, HACCP and organic certifications, phytosanitary inspection and third-party lab reports on request.</p>
        <a href="{{ route('contact') }}" class="btn btn-primary">Contact Us</a>
    </div>
</div>
@endsection
