// on document ready
$(function () {
    var App = new ApplicationView;
    App.historyEnable = true;
    if ($("#application").data("history-disable")) {
        App.historyEnable = false;
    }

    window.fmApp = App;

    //Проверяем атрибут data-history-disable 
    //указывающий файловому менеджеру вести или нет историю переходов в браузере.
    //Данный функционал добавлен для предотвращения изменения истории браузера 
    //при запуске файлового менеджера в режиме диалогового окна
    if (App.historyEnable) {
        window.fmRouter = new Router(App);
        Backbone.history.start();
    } else {
        App.render();
    }
});
