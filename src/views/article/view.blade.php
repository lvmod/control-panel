@extends('control::layouts.control')

@section('content')

@include('control::helpers.header', ['title'=>'Статьи', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <?php echo $article->body; ?> 
</section>
@endsection