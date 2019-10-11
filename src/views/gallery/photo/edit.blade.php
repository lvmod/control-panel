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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Галерея</h3>

                        <div class="box-tools pull-right">
                            <a href="#" class="btn btn-box-tool btn-add-file" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
                            <script>
                                $(function() {
                                    $(".btn-add-file").click(function(e) {
                                        e.stopPropagation();

                                        var fm = new FileManagerDialogView({
                                            single: true,
                                            viewer: "image",
                                            success: function(files) {
                                                if (files && files.length) {
                                                    console.log(files);
                                                }
                                            }
                                        });

                                        return false;
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-read-message">
                            <ul class="mailbox-attachments clearfix">
                            <li>
                                    <div style="width: 100%; height: 120px;
                                    background-image: url(https://sun9-70.userapi.com/c858432/v858432093/94d28/3Z2XlQ1cdc0.jpg);
                                    background-position: center center;
                                    background-repeat: no-repeat;
                                    background-size: cover;"></div>

                                    <div class="mailbox-attachment-info">
                                        <span class="mailbox-attachment-size">
                                            1,245 KB
                                            <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-remove"></i></a>
                                        </span>
                                    </div>
                                </li> <li>
                                    <div style="width: 100%; height: 120px;
                                    background-image: url(https://sun9-70.userapi.com/c858432/v858432093/94d28/3Z2XlQ1cdc0.jpg);
                                    background-position: center center;
                                    background-repeat: no-repeat;
                                    background-size: cover;"></div>

                                    <div class="mailbox-attachment-info">
                                        <span class="mailbox-attachment-size">
                                            1,245 KB
                                            <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-remove"></i></a>
                                        </span>
                                    </div>
                                </li> <li>
                                    <div style="width: 100%; height: 120px;
                                    background-image: url(https://sun9-70.userapi.com/c858432/v858432093/94d28/3Z2XlQ1cdc0.jpg);
                                    background-position: center center;
                                    background-repeat: no-repeat;
                                    background-size: cover;"></div>

                                    <div class="mailbox-attachment-info">
                                        <span class="mailbox-attachment-size">
                                            1,245 KB
                                            <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-remove"></i></a>
                                        </span>
                                    </div>
                                </li> <li>
                                    <div style="width: 100%; height: 120px;
                                    background-image: url(https://sun9-70.userapi.com/c858432/v858432093/94d28/3Z2XlQ1cdc0.jpg);
                                    background-position: center center;
                                    background-repeat: no-repeat;
                                    background-size: cover;"></div>

                                    <div class="mailbox-attachment-info">
                                        <span class="mailbox-attachment-size">
                                            1,245 KB
                                            <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-remove"></i></a>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div style="width: 100%; height: 120px;
                                    background-image: url(https://sun9-70.userapi.com/c858432/v858432093/94d28/3Z2XlQ1cdc0.jpg);
                                    background-position: center center;
                                    background-repeat: no-repeat;
                                    background-size: cover;"></div>

                                    <div class="mailbox-attachment-info">
                                        <span class="mailbox-attachment-size">
                                            1,245 KB
                                            <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-remove"></i></a>
                                        </span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
    </form>
    <!-- /.row -->
</section><!-- /.content -->

@endsection