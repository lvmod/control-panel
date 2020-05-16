@extends('control::layouts.control')

@section('content')
@include('control::helpers.header', ['title'=>'Редактирование категории', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ url('/control/category/update/'.$category->id) }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="hpanel">

                            @include('common.errors')

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5>
                                            Название:
                                        </h5>
                                        <div>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}"> </div>

                                        <br />
                                        <div>
                                            <input type="submit" name="submit" class="btn btn-primary" value="Сохранить"> 
                                            <a class="btn btn-default" href="/control/category">Отмена</a>
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