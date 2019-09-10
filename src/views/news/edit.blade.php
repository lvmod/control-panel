@extends('control::layouts.control')

@section('content')
<section class="content-header">
                    <div>
                        <h3 class="font-light m-b-xs" style="margin-top: 5px; margin-bottom: 3px;">
                            Редактирование новости                            <br>
                        </h3>
                    </div>
                    
        <ol class="breadcrumb">
            <li><a href="/control"><i class="fa fa-home pr-10"></i> Главная</a></li>
            <li class="active">Материалы</li><li class="active">Новости</li>
        </ol>                
</section>

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
                                            <input type="text" name="datapicker2" id="datapicker2" class="form-control" value="10.09.2019">                                        <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-th"></i>
                                            </span>
                                        </div>     
                                        <br/>
                                        
                                        <h5>
                                            Категория:
                                        </h5>
                                        <div class="input-group select2-bootstrap-append">
                                            <select name="category" id="category" class="form-control&#x20;select2-allow-clear"><option value="2">Аналитика</option>
                                            <option value="1">Общая</option></select>                                        <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" href='/category/add' data-select2-open="single-append-text">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                        <br>

                                        <div class="checkbox checkbox-success">
                                            <input type="hidden" name="checkbox3" value="0"><input type="checkbox" name="checkbox3" id="checkbox3" checked="checked" value="1">                                        <label for="checkbox3">
                                                Отображать новость на сайте                                        </label>
                                        </div>

                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <div >
                                                <input type="submit" name="submit" class="btn&#x20;btn-primary" value="&#x0421;&#x043E;&#x0445;&#x0440;&#x0430;&#x043D;&#x0438;&#x0442;&#x044C;">                                            &nbsp;
                                                                                            &nbsp;
                                                <a class="btn btn-default" href="/news">Отмена</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                        <h5>
                                            Заголовок новости:
                                        </h5>
                                    <div >
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $news->title) }}">                                    </div>

                                    <br/>
                                        <div class="col-lg-9">
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



<!-- Bootstrap шаблон... -->

<div class="container mt-4 mb-4">
    <div class="panel-body">
        <!-- Отображение ошибок проверки ввода -->
        @include('common.errors')

        <!-- Форма новой новости -->
        <form action="{{ url('/control/news/update/'.$news->id) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            
            <!-- Имя задачи -->
            <div class="form-group">
                <label for="task" class="col-sm-3 control-label">Новость</label>

                <div class="col-sm-6">
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $news->title) }}">
                </div>
            </div>

            <!-- Кнопка добавления задачи -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Добавить новость
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- TODO: Текущие задачи -->
@endsection