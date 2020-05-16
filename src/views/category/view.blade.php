@extends('control::layouts.control')

@section('content')

@include('control::helpers.header', ['title'=>'Категория', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <?php echo $category->name; ?> 
</section>
@endsection