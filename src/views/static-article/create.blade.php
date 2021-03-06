@extends('control::layouts.control')

@section('content')
@include('control::helpers.header', ['title'=>'Добавление фиксированной статьи', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ url('/control/static/article/store') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="hpanel">

                            @include('common.errors')

                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-lg-9">
                                    <h5>
                                        Ключевое слово - идентификатор статьи (англ.):
                                        </h5>
                                        <div>
                                            <input type="text" name="path" id="path" class="form-control" value="{{ old('path') }}"> </div>
                                        <br />

                                        <h5>
                                            Заголовок статьи:
                                        </h5>
                                        <div>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}"> </div>

                                        <br />
                                        <div>
                                            <input type="submit" name="submit" class="btn btn-primary" value="Добавить текст статьи"> 
                                            <a class="btn btn-default" href="/control/static/article">Отмена</a>
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