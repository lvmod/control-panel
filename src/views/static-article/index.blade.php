@extends('control::layouts.control')

@section('content')

@include('control::helpers.header', ['title'=>'Фиксированные статьи', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <a class="btn btn-success btn-sm" href="{{ url('/control/static/article/create') }}">
                Создать фиксированную статью
            </a>
        </div>
    </div>


    @if (count($staticArticle) > 0)
    @foreach ($staticArticle as $item)
    <div class="box box-widget">
        <div class='box-header with-border'>
            <div class='user-block'>
                <img class='img-circle' src='<?php
                                                if (isset($item->author->photo)) {
                                                    echo $item->author->photo;
                                                } else {
                                                    echo "/vendor/control-panel/dist/img/empty.png";
                                                }
                                                ?>'>
                <span class='username'><small>Автор: <span class="font-bold">{{ $item->author->name }}</span> </small></span>
                <span class='description'>Публикация: {{\Carbon\Carbon::parse($item->posted)->format('d.m.Y')}} </span>
            </div><!-- /.user-block -->
            <div class='box-tools' style='padding-top: 5px'>
                <a href="{{ url('/control/static/article/edit/'.$item->id) }}" class="btn btn-xs btn-default">Изменить</a>
                <a href="{{ url('/control/static/article/delete/'.$item->id) }}" class="btn btn-danger btn-xs sw-alert-delete">Удалить</a>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class='box-body' style='padding-top: 0px'>
            <?php if (!isset($_COOKIE['allcontents'])) : ?>
                <a href="{{ url('/control/static/article/edit/'.$item->id) }}">
                    <h4>{{ $item->title }}</h4>
                </a>
                <?php
                    $body = strip_tags($item->body);
                    echo mb_strlen($body, 'UTF-8') > 400 ? mb_substr($body, 0, 400, 'UTF-8') . '...' : $body;
                    ?>
            <?php else : ?>
                <a href="{{ url('/control/static/article/edit/'.$item->id) }}">
                    <h4>{{ $item->title }}</h4>
                </a>
                {{ $item->body }}
            <?php endif; ?>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
    @endforeach

    <div style="width: 450px; margin: 0 auto">
        {{ $staticArticle->links('control::pagination.custom') }}
    </div>

    @endif
</section>
@endsection