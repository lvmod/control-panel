@extends('control::layouts.control')

@section('content')

@include('control::helpers.header', ['title'=>'Файлы'])

<section class="content">
    <div id="application"></div>

    <!-- START APPLICATION SCRIPTS -->
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/router/router.js"></script>
    <script type="text/javascript">
    $(function () {
        var FM = new FileManagerView({el: $("#application")});
        FM.historyEnable = true;
        if ($("#application").data("history-disable")) {
            FM.historyEnable = false;
        }

        window.fmApp = FM;

        //Проверяем атрибут data-history-disable 
        //указывающий файловому менеджеру вести или нет историю переходов в браузере.
        //Данный функционал добавлен для предотвращения изменения истории браузера 
        //при запуске файлового менеджера в режиме диалогового окна
        if (FM.historyEnable) {
            window.fmRouter = new Router(FM);
            Backbone.history.start();
        } else {
            FM.render();
        }
    });
    </script>
    <!-- END APPLICATION SCRIPTS -->
</section>

@endsection