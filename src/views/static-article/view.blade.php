@extends('control::layouts.control')

@section('content')

@include('control::helpers.header', ['title'=>'Фиксированные статьи', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <?php echo $staticArticle->body; ?> 
</section>
@endsection