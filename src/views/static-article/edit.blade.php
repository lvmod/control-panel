@extends('control::layouts.control')

@section('content')
@include('control::helpers.header', ['title'=>'Редактирование фиксированной статьи', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ url('/control/static/article/update/'.$staticArticle->id) }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="hpanel">

                            @include('common.errors')

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-3">

                                        <br>
                                        <div class="basic-image-box"></div>
                                        <script type="text/javascript">
                                            $(function () {
                                                var basicImage = new BasicImageView({
                                                    el: $('.basic-image-box'),
                                                    id: {{ old('multimedia', $staticArticle->multimedia_id?:0) }},
                                                    inputName: 'multimedia'
                                                });
                                            });
                                        </script>

                                        <br>
                                        <br>
                                        <div>
                                            <input type="submit" name="submit" class="btn btn-primary" value="Сохранить"> 
                                            <a class="btn btn-danger sw-alert-delete"  href="{{ url('/control/static/article/delete/'.$staticArticle->id) }}">Удалить</a>
                                            <a class="btn btn-default" href="/control/static/article">Отмена</a>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                        Ключевое слово - идентификатор статьи (англ.):
                                        </h5>
                                        <div>
                                            <input type="text" name="path" id="path" class="form-control" value="{{ old('path', $staticArticle->title) }}"> </div>
                                        <br />

                                        <h5>
                                            Заголовок статьи:
                                        </h5>
                                        <div>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $staticArticle->title) }}"> </div>

                                        <br />
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <h5>
                                                    Текст статьи:
                                                </h5>
                                                <textarea name='body' class="form-control">{{ old('body', $staticArticle->body) }}</textarea>
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