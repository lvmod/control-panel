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
                                            <input type="text" name="datapicker2" id="datapicker2" class="form-control" value="10.09.2019"> <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-th"></i>
                                            </span>
                                        </div>
                                        <br />

                                        <h5>
                                            Категория:
                                        </h5>
                                        <div class="form-group">
                                            <select name="category" id="category" class="form-control">
                                                @foreach($category as $item)
                                                    <option value="{{$item->id}}" {{($item->id==old('category', $news->category->id))?'selected':''}}>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <br>

                                        <div class="checkbox checkbox-success">
                                            <input type="hidden" name="checkbox3" value="0"><input type="checkbox" name="checkbox3" id="checkbox3" checked="checked" value="1"> <label for="checkbox3">
                                                Отображать новость на сайте </label>
                                        </div>

                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <div>
                                                <input type="submit" name="submit" class="btn&#x20;btn-primary" value="&#x0421;&#x043E;&#x0445;&#x0440;&#x0430;&#x043D;&#x0438;&#x0442;&#x044C;"> &nbsp;
                                                &nbsp;
                                                <a class="btn btn-default" href="/news">Отмена</a>
                                            </div>
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