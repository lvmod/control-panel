@extends('control::layouts.control')

@section('content')

@include('control::helpers.header', ['title'=>$gallery->title, 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    
</section>
@endsection