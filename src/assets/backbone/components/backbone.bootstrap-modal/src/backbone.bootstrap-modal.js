/**
 * Bootstrap Modal wrapper for use with Backbone.
 *
 * Takes care of instantiation, manages multiple modals,
 * adds several options and removes the element from the DOM when closed
 *
 * @author Charles Davison <charlie@powmedia.co.uk>
 *
 * Events:
 * shown: Fired when the modal has finished animating in
 * hidden: Fired when the modal has finished animating out
 * cancel: The user dismissed the modal
 * ok: The user clicked OK
 */
(function ($, _, Backbone) {

    //Set custom template settings
    var _interpolateBackup = _.templateSettings;
    _.templateSettings = {
        interpolate: /\{\{(.+?)\}\}/g,
        evaluate: /<%([\s\S]+?)%>/g
    };

    var template = _.template('\
    <div class="modal-dialog"><div class="modal-content">\
    <% if (title) { %>\
      <div class="modal-header">\
        <% if (allowCancel) { %>\
          <a class="close">&times;</a>\
        <% } %>\
        <h4>{{title}}</h4>\
      </div>\
    <% } %>\
    <div class="modal-body">{{content}}</div>\
    <% if (showFooter) { %>\
      <div class="modal-footer">\
        <% if (allowCancel) { %>\
          <% if (cancelText) { %>\
            <a href="#" class="btn cancel">{{cancelText}}</a>\
          <% } %>\
        <% } %>\
        <a href="#" class="btn ok btn-primary">{{okText}}</a>\
      </div>\
    <% } %>\
    </div></div>\
  ');

    //Reset to users' template settings
    _.templateSettings = _interpolateBackup;


    var Modal = Backbone.View.extend({

        className: 'modal',

        events: {
            'click .close': function (event) {
                event.preventDefault();

                this.trigger('cancel');

                if (this.options.content && this.options.content.trigger) {
                    this.options.content.trigger('cancel', this);
                }
            },
            'click .cancel': function (event) {
                event.preventDefault();

                this.trigger('cancel');

                if (this.options.content && this.options.content.trigger) {
                    this.options.content.trigger('cancel', this);
                }
            },
            'click .ok': function (event) {
                event.preventDefault();

                this.trigger('ok');

                if (this.options.content && this.options.content.trigger) {
                    this.options.content.trigger('ok', this);
                }

                if (this.options.okCloses) {
                    this.close();
                }
            },
            'keypress': function (event) {
                if (this.options.enterTriggersOk && event.which == 13) {
                    event.preventDefault();

                    this.trigger('ok');

                    if (this.options.content && this.options.content.trigger) {
                        this.options.content.trigger('ok', this);
                    }

                    if (this.options.okCloses) {
                        this.close();
                    }
                }
            }
        },

        /**
         * Creates an instance of a Bootstrap Modal
         *
         * @see http://twitter.github.com/bootstrap/javascript.html#modals
         *
         * @param {Object} options
         * @param {String|View} [options.content]     Modal content. Default: none
         * @param {String} [options.title]            Title. Default: none
         * @param {String} [options.okText]           Text for the OK button. Default: 'OK'
         * @param {String} [options.cancelText]       Text for the cancel button. Default: 'Cancel'. If passed a falsey value, the button will be removed
         * @param {Boolean} [options.allowCancel      Whether the modal can be closed, other than by pressing OK. Default: true
         * @param {Boolean} [options.escape]          Whether the 'esc' key can dismiss the modal. Default: true, but false if options.cancellable is true
         * @param {Boolean} [options.animate]         Whether to animate in/out. Default: false
         * @param {Function} [options.template]       Compiled underscore template to override the default one
         * @param {Boolean} [options.enterTriggersOk] Whether the 'enter' key will trigger OK. Default: false
         */
        initialize: function (options) {
            this.options = _.extend({
                title: null,
                okText: 'OK',
                focusOk: true,
                okCloses: true,
                cancelText: 'Cancel',
                showFooter: true,
                allowCancel: true,
                escape: true,
                animate: false,
                template: template,
                enterTriggersOk: false
            }, options);

            //Добавляем в представление параметр inModalView указывающий 
            //что представление запускатеся в модальном окне
            if (this.options.content) {
                this.options.content.inModalView = true;
            }
        },

        /**
         * Creates the DOM element
         *
         * @api private
         */
        render: function () {
            var $el = this.$el,
                options = this.options,
                content = options.content;

            //Create the modal container
            $el.html(options.template(options));

            var $content = this.$content = $el.find('.modal-body')

            //Insert the main content if it's a view
            if (content && content.$el) {
                content.render();
                $el.find('.modal-body').html(content.$el);
            }

            if (options.animate)
                $el.addClass('fade');

            this.isRendered = true;

            return this;
        },

        /**
         * Renders and shows the modal
         *
         * @param {Function} [cb]     Optional callback that runs only when OK is pressed.
         */
        open: function (cb) {
            if (!this.isRendered)
                this.render();

            var self = this,
                $el = this.$el;

            //Create it
            $el.modal(_.extend({
                keyboard: this.options.allowCancel,
                backdrop: this.options.allowCancel ? true : 'static'
            }, this.options.modalOptions));

            //Focus OK button
            $el.one('shown.bs.modal', function () {
                if (self.options.focusOk) {
                    $el.find('.btn.ok').focus();
                }

                if (self.options.content && self.options.content.trigger) {
                    self.options.content.trigger('shown', self);
                }

                self.trigger('shown');
            });

            //Adjust the modal and backdrop z-index; for dealing with multiple modals
            var numModals = Modal.count,
                $backdrop = $('.modal-backdrop:eq(' + numModals + ')'),
                backdropIndex = parseInt($backdrop.css('z-index'), 10),
                elIndex = parseInt($backdrop.css('z-index'), 10);

            $backdrop.css('z-index', backdropIndex + numModals);
            this.$el.css('z-index', elIndex + numModals);

            if (this.options.allowCancel) {
                $backdrop.one('click', function () {
                    if (self.options.content && self.options.content.trigger) {
                        self.options.content.trigger('cancel', self);
                    }

                    self.trigger('cancel');
                });

                //        $(document).one('keyup.dismiss.modal', function (e) {
                //          e.which == 27 && self.trigger('cancel');
                //
                //          if (self.options.content && self.options.content.trigger) {
                //            e.which == 27 && self.options.content.trigger('shown', self);
                //          }
                //        });
            }

            this.on('cancel', function () {
                self.close();
            });

            Modal.count++;

            //Run callback on OK if provided
            if (cb) {
                self.on('ok', cb);
            }


            //Обновляем историю браузера
            this.pushStateHistoryModal(this);

            return this;
        },
        //По событию перехода на предыдущую страницу браузера (history.back())
        //закрывает текущую модаль, предотвращая полное обновление страницы
        pushStateHistoryModal: function (modal) {
            //История браузера
            //https://developer.mozilla.org/ru/docs/Web/API/History_API
            if (modal && modal.cid) {
                var cbFuncName = 'modal_' + modal.cid;
                history.replaceState({ cb: cbFuncName }, '');
                history.pushState(null, null, '');
                window.historyCallbackFunctions = window.historyCallbackFunctions || [];
                window.historyCallbackFunctions[cbFuncName] = function (e) {
                    delete window.historyCallbackFunctions[cbFuncName];
                    modal.historyBackDone = true;

                    // Если не была нажата кнопка "отмена" или "ок" в окне диалога, 
                    // но была нажата кнопка "назад" в браузере, то закрываем диалог
                    if (!modal.historyBackCall) {
                        if (modal.options.allowCancel) {
                            modal.$('.cancel:first').trigger('click');
                        } else {
                            modal.$('.ok:first').trigger('click');
                        }
                    }
                    history.replaceState(null, '');

                    //Вызываем функцию обратного вызова при закрытии модали, если такая функция задана
                    var closeCallback = Utils.getObjectValue(modal, 'closeCallbackFunction.func');
                    if (_.isFunction(closeCallback)) {
                        var ctx = Utils.getObjectValue(modal, 'closeCallbackFunction.context');
                        var args = Utils.getObjectValue(modal, 'closeCallbackFunction.args');
                        closeCallback.apply(ctx, args);
                    }
                };

                modal.$el.one('hidden.bs.modal', function () {
                    // Если не была нажата кнопка "назад" в браузере,
                    // но была нажата кнопка "отмена" или "ок" в окне диалога, 
                    // то делаем возврат в истории браузера, запрещая повторную попытку 
                    // скрыть диалог (modal.historyBackCall = true), так как он уже скрыт
                    if (!modal.historyBackDone) {
                        modal.historyBackCall = true;
                        history.back();
                    }
                });
            }
        },
        //Устанавливает функцию вызываемую после закрытия модали и очистки истории браузера.
        //Выполняет закритие модали
        closeAndCallbackFunction: function (func, context, args) {
            this.closeCallbackFunction = { func: func, context: context, args: args };
            this.close();
        },
        /**
         * Closes the modal
         */
        close: function () {
            var self = this,
                $el = this.$el;

            //Check if the modal should stay open
            if (this._preventClose) {
                this._preventClose = false;
                return;
            }

            $el.one('hidden.bs.modal', function onHidden(e) {
                // Ignore events propagated from interior objects, like bootstrap tooltips
                if (e.target !== e.currentTarget) {
                    return $el.one('hidden', onHidden);
                }

                self.remove();

                if (self.options.content && self.options.content.trigger) {
                    self.options.content.trigger('hidden', self);
                }
                if (self.options.content && self.options.content.viewHelperСacheRemove) {
                    self.options.content.viewHelperСacheRemove(self.options.content);
                }
                self.trigger('hidden');

                //Костыль. Иначе перестают прокручиваться оставшиеся открытые 
                //модали после закрытия текущей
                if (Modal.count > 0) {
                    $("body").addClass('modal-open');
                }
            });

            $el.modal('hide');

            Modal.count--;
        },
        /**
         * Stop the modal from closing.
         * Can be called from within a 'close' or 'ok' event listener.
         */
        preventClose: function () {
            this._preventClose = true;
        }
    }, {
        //STATICS

        //The number of modals on display
        count: 0
    });


    //EXPORTS
    //CommonJS
    if (typeof require == 'function' && typeof module !== 'undefined' && exports) {
        module.exports = Modal;
    }

    //AMD / RequireJS
    if (typeof define === 'function' && define.amd) {
        return define(function () {
            Backbone.BootstrapModal = Modal;
        })
    }

    //Regular; add to Backbone.Bootstrap.Modal
    else {
        Backbone.BootstrapModal = Modal;
    }

})(jQuery, _, Backbone);

$(function () {
    window.addEventListener('popstate', function (e) {
        if (e.state && e.state.cb && window.historyCallbackFunctions && window.historyCallbackFunctions[e.state.cb]) {
            window.historyCallbackFunctions[e.state.cb].apply(this, arguments);
        }
    }, false);
})