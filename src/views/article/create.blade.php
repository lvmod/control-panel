@extends('control::layouts.control')

@section('content')
@include('control::helpers.header', ['title'=>'Добавление статьи', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ url('/control/article/store') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="hpanel">

                            @include('common.errors')

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-3">

                                        <h5>
                                            Дата публикации:
                                        </h5>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="posted" id="posted" autocomplete="off" type="text" class="datepicker form-control pull-right" value="{{ old('posted', \Carbon\Carbon::now()->format('d.m.Y')) }}">
                                        </div>
                                        <br />

                                        <br>
                                        <br>
                                        <div class="basic-image-box"></div>
                                        <script type="text/javascript">
                                            $(function () {
                                                var basicImage = new BasicImageView({
                                                    el: $('.basic-image-box'),
                                                    id: {{ old('multimedia', 0) }},
                                                    inputName: 'multimedia'
                                                });
                                            });
                                        </script>
                                        
                                        <br>
                                        <br>
                                        <!-- Hidden нужен для инициализации чекбокса. Если статья создается то visible = null, 
                                        а если пришла после проверки валидации, то visible либо "on" либо "0" -->
                                        <input type="hidden" name="visible" value="0">
                                        <input type="checkbox" name="visible" id="visible" class="minimal" {{ old('visible')||old('visible')===null?'checked':'' }}>
                                        Отображать статью на сайте

                                        <br>
                                        <br>
                                        <div>
                                            <input type="submit" name="submit" class="btn btn-primary" value="Сохранить"> 
                                            <a class="btn btn-default" href="/control/article">Отмена</a>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                        <h5>
                                            Заголовок статьи:
                                        </h5>
                                        <div>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}"> </div>

                                        <br />
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <h5>
                                                    Текст статьи:
                                                </h5>
                                                <textarea name='body' class="form-control">{{ old('body') }}</textarea>
                                            </div>
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