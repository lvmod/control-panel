@extends('control::layouts.control')

@section('content')
@include('control::helpers.header', ['title'=>'Добавление галереи фотографий', 'items'=>app()->controlMenu->breadcrumb()])

<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ url('/control/gallery-photo/store') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="hpanel">

                            @include('common.errors')

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-3">
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
                                            <input type="submit" name="submit" class="btn btn-primary" value="Добавить фото"> 
                                            <a class="btn btn-default" href="/control/gallery-photo">Отмена</a>
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