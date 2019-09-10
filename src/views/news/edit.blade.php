@extends('control::layouts.control')

@section('content')

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