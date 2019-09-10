@extends('control::layouts.control')

@section('content')

<section class="content-header">
                    <div>
                        <h3 class="font-light m-b-xs" style="margin-top: 5px; margin-bottom: 3px;">
                            Новости                            <br>
                        </h3>
                    </div>
                    
        <ol class="breadcrumb">
            <li><a href="/control"><i class="fa fa-home pr-10"></i> Главная</a></li>
            <li class="active">Материалы</li><li class="active">Новости</li>
        </ol>                
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <a class="btn btn-success btn-sm" href="{{ url('/control/news/create') }}">
                Создать новость
            </a>
        </div>
    </div>


    @if (count($news) > 0)
        @foreach ($news as $item)
        <div class="box box-widget">
            <div class='box-header with-border'>
                <div class='user-block'>
                    <!-- <img class='img-circle' src='<?php
                    // if (isset($item['author_photo'])) {
                    //     echo $this->basePath($item['author_photo']);
                    // } else {
                    //     echo $this->basePath('images/people/empty.png');
                    // }
                    ?>'> -->
                    <span class='username'><small>Автор: <span class="font-bold">{{ $item->author->name }}</span> </small></span>
                    <span class='description'>Публикация: 
                        <?php
                        $posted = new DateTime($item->posted);
                        echo $posted->format('d.m.Y');
                        ?>
                    </span>
                </div><!-- /.user-block -->
                <div class='box-tools' style='padding-top: 5px'>
                    <a href="{{ url('/control/news/edit/'.$item->id) }}"><button class="btn btn-xs btn-default">Изменить</button></a>
                    <a href="{{ url('/control/news/delete/'.$item->id) }}"><button class="btn btn-danger btn-xs btn-default">Удалить</button></a>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class='box-body' style='padding-top: 0px'>
                <?php if (!isset($_COOKIE['allcontents'])): ?>
                    <a href="{{ url('/control/news/edit/'.$item->id) }}"> <h4>{{ $item->title }}</h4></a>
                    <?php
                    $body = strip_tags($item->body);
                    echo mb_strlen($body, 'UTF-8') > 400 ? mb_substr($body, 0, 400, 'UTF-8') . '...' : $body;
                    ?>
                <?php else: ?>
                    <a href="{{ url('/control/news/edit/'.$item->id) }}"> <h4>{{ $item->title }}</h4></a>
                    {{ $item->body }}
                <?php endif; ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->                                        
        @endforeach
    @endif
</section>
@endsection