@extends('control::layouts.control')

@section('content')

@include('control::helpers.header', ['title'=>'Категории', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <a class="btn btn-success btn-sm" href="{{ url('/control/category/create') }}">
                Создать категорию
            </a>
        </div>
    </div>


    @if (count($category) > 0)
    @foreach ($category as $item)
    <div class="box box-widget">
        <div class='box-header with-border'>
            <div class='box-tools' style='padding-top: 5px'>
                <a href="{{ url('/control/category/edit/'.$item->id) }}" class="btn btn-xs btn-default">Изменить</a>
                <a href="{{ url('/control/category/delete/'.$item->id) }}" class="btn btn-danger btn-xs sw-alert-delete">Удалить</a>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class='box-body' style='padding-top: 0px'>
            <a href="{{ url('/control/category/edit/'.$item->id) }}">
                <h4>{{ $item->name }}</h4>
            </a>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
    @endforeach

    <div style="text-align: center;">
        {{ $category->links('control::pagination.custom') }}
    </div>

    @endif
</section>
@endsection