@extends('control::layouts.control')

@section('content')
<?php 
    $title = 'Добавление галереи';
    if($type=='image') {
        $title .= ' изображений';
    } else if($type=='video') {
        $title .= ' видео';
    } 
?>
@include('control::helpers.header', ['title'=>$title, 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ url('/control/gallery/store') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="hpanel">

                            @include('common.errors')

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                    <input type="hidden" name="type" id="type" value="{{ $type }}">
                                        <h5>
                                            Заголовок:
                                        </h5>
                                        <div>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}"> </div>

                                        <br>
                                        <div>
                                            <input type="submit" name="submit" class="btn btn-primary" value="Добавить фото"> 
                                            <a class="btn btn-default" href="/control/gallery">Отмена</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

</section><!-- /.content -->

@endsection