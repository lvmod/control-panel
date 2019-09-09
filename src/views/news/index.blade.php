@extends('control::layouts.control')

@section('content')


<div class="container mt-4 mb-4">

    <!-- Кнопка добавления новости -->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <a class="btn btn-default" href="{{ url('/control/news/create') }}">
                <i class="fa fa-plus"></i> Добавить новость
            </a>
        </div>
    </div>

    @if (count($news) > 0)
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped task-table">

                <!-- Заголовок таблицы -->
                <thead>
                <th>Новости</th>
                <th>&nbsp;</th>
                </thead>

                <!-- Тело таблицы -->
                <tbody>
                    @foreach ($news as $item)
                    <tr>
                        <!-- Имя задачи -->
                        <td class="table-text">
                            <div>{{ $item->title }}</div>
                        </td>

                        <!-- Кнопка Удалить -->
                        <td>
                            <form action="{{ url('/control/news/delete/'.$item->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" id="delete-news-{{ $item->id }}" class="btn btn-danger">
                                    <i class="fa fa-btn fa-trash"></i>Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection