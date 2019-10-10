@extends('control::layouts.control')

@section('content')
@include('control::helpers.header', ['title'=>'Добавление галереи', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ url('/control/gallery/store') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="hpanel">

                            @include('common.errors')

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h5>
                                            Приоритет вывода:
                                        </h5>
                                        <div>
                                            <input type="number" name="priority" id="priority" class="form-control" value="{{ old('priority') }}"> </div>

                                        <br>
                                        <br>
                                        <div class="gallery-append-box">
                                            <script type="text/javascript">
                                                $(function () {
                                                    var galleryAppendView = new GalleryAppendView({
                                                        el: $('.gallery-append-box'),
                                                        id: "{{ old('multimedia') }}",
                                                        multimediaInputName: 'multimedia'
                                                    });
                                                });
                                            </script>
                                        </div>
                                        
                                        <br>
                                        <br>
                                        <div>
                                            <input type="submit" name="submit" class="btn btn-primary" value="Сохранить"> 
                                            <a class="btn btn-default" href="/control/gallery">Отмена</a>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                        <h5>
                                            Заголовок:
                                        </h5>
                                        <div>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}"> </div>
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