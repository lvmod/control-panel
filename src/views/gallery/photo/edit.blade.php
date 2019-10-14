@extends('control::layouts.control')

@section('content')
@include('control::helpers.header', ['title'=>'Редактирование галереи фоторгафий', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <form action="{{ url('/control/gallery-photo/update/'.$gallery->id) }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
        @include('common.errors')

        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="box box-primary">
                    <div class="box-body ">
                        <h5>
                            Заголовок:
                        </h5>
                        <div>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $gallery->title) }}"> </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-xs-4" style="padding-right: 2px">
                                <input type="submit" name="submit" class="btn btn-primary" value="Сохранить" style="width: 100%;">
                            </div>
                            <div class="col-xs-4" style=" padding-left: 1px; padding-right: 1px;">
                                <a class="btn btn-danger sw-alert-delete" href="{{ url('/control/gallery-photo/delete/'.$gallery->id) }}" style="width: 100%">Удалить</a>
                            </div>
                            <div class="col-xs-4" style="padding-left: 2px">
                                <a class="btn btn-default" href="/control/gallery-photo" style="width: 100%;">Отмена</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-lg-8 col-md-7">
                <div class="box box-primary gallery-box">
                    
                </div>
                <script>
                    $(function() {
                        var galleryView = new GalleryView({
                            el: $('.gallery-box'),
                            id: "{{ $gallery->id }}",
                            baseUrl: "/control/gallery-photo/api/{{ $gallery->id }}",
                            filePath: "{{$filePath}}",
                        });
                    });
                </script>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
    </form>
    <!-- /.row -->
</section><!-- /.content -->

@endsection