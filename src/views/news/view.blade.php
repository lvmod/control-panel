@extends('control::layouts.control')

@section('content')

@include('control::helpers.header', ['title'=>'Новости', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <?php echo $news->body; ?> 
</section>
@endsection