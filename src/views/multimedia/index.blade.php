@extends('control::layouts.control')

@section('content')

@include('control::helpers.header', ['title'=>'Файлы'])

<section class="content">
    <script src="/vendor/control-panel/plugins/jquery-tmpl/jquery.tmpl.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/plugins/jquery-loading-overlay/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/plugins/fotorama/fotorama.js"></script>

    <!-- BACKBONE SCRIPTS -->
    <script type="text/javascript" src="/vendor/control-panel/backbone/components/underscore/underscore-min.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/components/JSON-js/json2.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/components/backbone/backbone-min.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/components/backbone.bootstrap-modal/src/backbone.bootstrap-modal.js"></script>
    <!-- <script type="text/javascript" src="/vendor/control-panel/plugins/isotope/isotope.pkgd.min.js"></script>
        <script type="text/javascript" src="/vendor/control-panel/plugins/iCheck/icheck.min.js"></script> -->

    <!-- START APPLICATION SCRIPTS -->
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/helper/Utils.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/helper/UID.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/helper/PluginsManager.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/helper/TemplateManager.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/model/FileModel.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/model/FilesModel.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/model/ArticleFilesModel.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/collection/FileCollection.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/FileView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/FilesView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/ArticleFilesView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/FolderNameModal.js"></script>
    <!-- END APPLICATION SCRIPTS -->

    <div id="application"></div>

    <!-- START APPLICATION SCRIPTS -->
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/ApplicationView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/router/router.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/start.js"></script>
    <!-- END APPLICATION SCRIPTS -->
</section>

@endsection