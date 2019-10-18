@extends('control::layouts.control')

@section('content')
<?php 
    $title = 'Галерея';
    if($type=='image') {
        $title .= ' изображений';
    } else if($type=='video') {
        $title .= ' видео';
    } 
?>
@include('control::helpers.header', ['title'=>$title, 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <a class="btn btn-success btn-sm" href="{{ url('/control/gallery/create/'.$type) }}">
                Добавить
            </a>
        </div>
    </div>

    @if (count($gallery) > 0)
    @foreach ($gallery as $item)
    <div class="box box-widget">
        <div class='box-header with-border'>
            <div class='user-block'>
                &nbsp
            </div><!-- /.user-block -->
            <div class='box-tools' style='padding-top: 5px'>
                <a href="{{ url('/control/gallery/edit/'.$item->id) }}" class="btn btn-xs btn-default">Изменить</a>
                <a href="{{ url('/control/gallery/delete/'.$item->id) }}" class="btn btn-danger btn-xs sw-alert-delete">Удалить</a>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class='box-body' style='padding-top: 0px'>
            <a href="{{ url('/control/gallery/edit/'.$item->id) }}">
                <h4>{{ $item->title }}</h4>
            </a>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
    @endforeach

    <div style="width: 450px; margin: 0 auto">
        {{ $gallery->links('control::pagination.custom') }}
    </div>

    @endif
</section>
@endsection