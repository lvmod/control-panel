@extends('control::layouts.control')

@section('content')
@include('control::helpers.header', ['title'=>'Редактирование новости', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ url('/control/news/update/'.$news->id) }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="hpanel">

                            @include('common.errors')

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-3">

                                        <h5>
                                            Публикация:
                                        </h5>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="datapicker2" id="datapicker2" autocomplete="off" type="text" class="datepicker form-control pull-right">
                                        </div>
                                        <br />

                                        <h5>
                                            Категория:
                                        </h5>
                                        <select name="category" id="category" class="form-control select2">
                                            @foreach($category as $item)
                                            <option value="{{$item->id}}" {{($item->id==old('category', $news->category->id))?'selected':''}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>

                                        <br>
                                        <br>
                                        <input type="checkbox" name="checkbox3" id="checkbox3" class="minimal" checked>
                                        Отображать новость на сайте

                                        <br>
                                        <br>
                                        <div>
                                            <input type="submit" name="submit" class="btn btn-primary" value="Сохранить"> 
                                            <a class="btn btn-danger sw-alert-delete"  href="{{ url('/control/news/delete/'.$news->id) }}">Удалить</a>
                                            <a class="btn btn-default" href="{{ (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '/control/news' }}">Отмена</a>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                        <h5>
                                            Заголовок новости:
                                        </h5>
                                        <div>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $news->title) }}"> </div>

                                        <br />
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <h5>
                                                    Текст новости:
                                                </h5>
                                                <textarea name='body' class="form-control">{{ old('body', $news->body) }}</textarea>
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