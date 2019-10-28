$.getScriptSync = function (url) {
    $.ajax({
        async: false,
        url: url,
        dataType: "script"
    });
};

$.getJSONSync = function (url) {
    return $.ajax({
        async: false,
        type: 'GET',
        url: url,
        dataType: 'json'
    }).responseJSON;
};

$.getSync = function (url) {
    return $.ajax({
        async: false,
        type: 'GET',
        url: url,
    }).responseText;
};

console.flags = {
    debug: false,
    trace: false
};
console.debug = function() {
    if(console.flags.debug === true) {
        console.log.apply(this, ["debug"].concat([].slice.call(arguments)));
    }
};
console.trace = function() {
    if(console.flags.trace === true) {
        console.log.apply(this, ["trace"].concat([].slice.call(arguments)));
    }
};
window.Utils = {
    getURL: function (path, urlRoot) {
        urlRoot = urlRoot || applicationBasePath || "";
//        if (!urlRoot) {
//            return "/";
//        }

        if (!path) {
            return urlRoot;
        }

        if (urlRoot.endsWith("/")) {
            urlRoot = urlRoot.substring(0, urlRoot.length - 1);
        }

        if (path.startsWith("/")) {
            path = path.substring(1, path.length);
        }

        return urlRoot + "/" + path;
    },
    equals: function (obj1, obj2) {
        if (obj1 === obj2)
            return true;
        if (!obj1 || !obj2 || typeof (obj1) !== "object" || typeof (obj2) !== "object")
            return false;
        //Проверяем является ли объект obj1 функцией, 
        //если да то предполагаем что obj2 тоже функция и сранвиваем коды функций 
        if (typeof (obj1) === "function") {
            if (obj1.toString() === obj2.toString())
                return true;
            else
                return false;
        }

        //Если obj2 является функцией, значит предыдущее условие 
        //показало что obj1 не является функцией, а значит obj1 != obj2
        if (typeof (obj2) === "function") {
            return false;
        }

        var obj1PropertyCount = Object.keys(obj1).length;
        var obj2PropertyCount = Object.keys(obj2).length;
        //Если количество свойств сравниваемых объектов разное, то объекты не равны
        if (obj1PropertyCount !== obj2PropertyCount)
            return false;
        //Так как предыдущее условие показало, что кол-во свойст у объектов равны, 
        //проверяем если кол-во свойств объектов равно 0, то объекты пустые, 
        //а соответственно равны
        if (obj1PropertyCount === 0)
            return true;
        for (var property in obj1) {
            var prop1 = obj1[property];
            var prop2 = obj2[property];
            //Если свойсвто prop1 является объектом, то предполагаем, 
            //что prop2 тоже объекта и проверяем на равенстов объектов свойства prop1 и prop2 
            if (typeof (prop1) === "object") {
                if (!this.equals(prop1, prop2)) {
                    return false;
                }
                //Иначе если prop1 не является обхектом, а prop2 является объектом, 
                //останавливем сравнение
            } else if (typeof (prop2) === "object") {
                return false;
                //Если prop1 и prop2 не яляются объектами, то просто их сравниваем
            } else if (typeof (prop1) !== "object" && typeof (prop2) !== "object") {
                if (prop1 !== prop2)
                    return false;
            }
        }

        return true;
    },
    indexOf: function (array, item) {
        if (!array || !item || !Array.isArray(array))
            return -1;
        for (var i = 0; i < array.length; i++) {
            try {
                if (this.equals(array[i], item)) {
                    return i;
                }
            } catch (e) {
                console.warn("Ошибка сравнения объектов. Возможно рекурсивная ссылка");
                return -1;
            }
        }
        return -1;
    },
    contains: function (array, item) {
        return this.indexOf(array, item) >= 0;
    },
    //----------------------------------------------------------------------
    //Получение значения объекта. object - сам объект, subObject - строка содержащая описание подъобъекта.
    getObjectValue: function (object, subObject) {
        //Если присутствуют под объекты.
        if (object && subObject) {
//            var subObjects = subObject.split('.');
            //разбиваем строку subObject через "." не трогая при этом точки в угловых скобках [sdf.sdf]
            var subObjects = subObject
                    .replace(/\[[\wа-яА-ЯёЁ\d\."']*\]/g, function (item) {
                        return item.replace(".", "<<8>>")
                    })
                    .split(".")
                    .map(function (item) {
                        return item.replace(/<<8>>/g, ".");
                    });
            //Перебираем под объекты
            for (var i = 0; i < subObjects.length; i++) {
                var index = subObjects[i].match(/\[.*\]/);
                var subObj = subObjects[i].replace(/\[.*\]/, "");
                if (subObj) {
                    var lastObj = subObj;

                    if (object === null) {
                        console.debug("Ошибка получения объекта: " + subObject + "; Не удается найти свойство: " + "\"" + subObj + "\"");
                        return;
                    }

                    object = object[subObj];
                    if (object === undefined) {
                        console.debug("Ошибка получения объекта: " + subObject + "; Не удается найти свойство: " + "\"" + subObj + "\"");
                        return;
                    }

                    //Проверяем является ли под объект массивом
                    if (index) {
                        var rexp = /\[([\wа-яА-ЯёЁ\d\.]+)\]|\[["|']([\wа-яА-ЯёЁ\d\.]+)["|']\]/g;
                        var matchArray;
                        //Поиск всех индексов для n-мерного массива
                        while ((matchArray = rexp.exec(index))) {
                            var matchIndex = matchArray[1] || matchArray[2];
                            if (matchIndex) {
                                object = object[matchIndex];
                                if (object === undefined) {
                                    console.debug("Ошибка получения объекта: " + subObject + "; Не существует элемента с индексом: \"" + matchIndex + "\" в объекте: " + lastObj);
                                    return;
                                }
                            } else {
                                console.debug("Ошибка получения объекта: " + subObject + "; Не могу получить указанный объект. Ошибка получения индекса элемента.");
                                return;
                            }
                        }
                    }
                } else {
                    console.debug("Ошибка получения объекта: " + subObject + "; Не могу получить указанный объект.");
                    return;
                }
            }
        }
        return object;
    },
    getObjectValueOrDefault: function (object, subObject, defValue) {
        var result = Utils.getObjectValue(object, subObject);
        if (result === undefined || result === null) {
            if (defValue !== undefined) {
                return defValue;
            }
        }
        return result;
    },
    //Установка значения объекта. object - сам объект, subObject - строка содержащая описание подъобъекта, 
    //value - новое значение.
    setObjectValue: function (object, subObject, value) {
        //Если присутствуют под объекты.
        var data = object;
        var lastObject = object;
        var lastObj = "";
        if (object && subObject) {
//            var subObjects = subObject.split('.');
            //разбиваем строку subObject через "." не трогая при этом точки в угловых скобках [sdf.sdf]
            var subObjects = subObject
                    .replace(/\[[\wа-яА-ЯёЁ\d\."']*\]/g, function (item) {
                        return item.replace(".", "<<8>>")
                    })
                    .split(".")
                    .map(function (item) {
                        return item.replace(/<<8>>/g, ".");
                    });
            //Перебираем под объекты
            for (var i = 0; i < subObjects.length; i++) {
                var index = subObjects[i].match(/\[.*\]/);
                var subObj = subObjects[i].replace(/\[.*\]/, "");
                if (subObj) {
                    lastObj = subObj;
                    lastObject = object;
                    object = object[subObj];
                    if (!object) {
                        object = lastObject;
                        if (object && typeof (object) === "object") {
                            object[subObj] = {};
                            lastObj = subObj;
                            lastObject = object;
                            object = object[subObj];
                        } else {
                            //console.error("Ошибка получения объекта: " + subObject + "; Не удается установить свойство: " + "\"" + subObj + "\"");
                            return data;
                        }
                    }

                    //Проверяем является ли под объект массивом
                    if (index) {
                        var rexp = /\[([\wа-яА-ЯёЁ\d\.]+)\]|\[["|']([\wа-яА-ЯёЁ\d\.]+)["|']\]/g;
                        var matchArray;
                        //Поиск всех индексов для n-мерного массива
                        while ((matchArray = rexp.exec(index))) {
                            var matchIndex = matchArray[1] || matchArray[2];
                            if (matchIndex) {
                                if (!isNaN(matchIndex)) {
                                    matchIndex = parseInt(matchIndex);
                                    if($.isEmptyObject(object)) {
                                        lastObject[lastObj] = [];
                                        object = lastObject[lastObj];
                                    }
                                }
                                lastObject = object;

                                object[matchIndex] = object[matchIndex] || {};
                                object = object[matchIndex];

                                lastObj = matchIndex;
                            } else {
                                //console.error("Ошибка получения объекта: " + subObject + "; Не могу получить указанный объект. Ошибка получения индекса элемента.");
                                return data;
                            }
                        }
                    }
                } else {
                    //console.error("Ошибка получения объекта: " + subObject + "; Не могу получить указанный объект.");
                    return data;
                }
            }
            if (lastObject && lastObj!==undefined && lastObject[lastObj]) {
                lastObject[lastObj] = value;
            }
        } else {
            data = value;
        }
        return data;
    },
    showModalConfirmDialog: function (title, template, content, okText, cancelText, okCallback, cancelCallback, dialogProps) {
        var ConfirmView = Backbone.View.extend({
            //template: '<span>ConfirmDialog !!!</span>',
            render: function () {
                if (_.isString(template)) {
                    TemplateManager.render(this, template, content,
                            function (context, template, data) {
                            });
                    return this;
                } else if (_.isFunction(template)) {
                    this.template = template();
                } else if (!template && _.isArray(content)) {
                    var block = "<div>";
                    for (var i = 0; i < content.length; i++) {
                        var name = content[i].name;
                        var value = content[i].value;
                        block = block + "<div><span style='font-weight: 600;'>" + name + ": </span><span>" + value + "</span></div>";
                    }
                    block = block + "</div>";
                    this.template = block;
                }
                var tmpl = _.template(this.template);
                if (this.html) {
                    this.html(tmpl(content));
                } else {
                    this.$el.html(tmpl(content));
                }
                return this;
            }
        });
        var confirmView = new ConfirmView();

        TemplateManager.get("modal-template", function (template) {
            var modal = new Backbone.BootstrapModal(_.extend({
                content: confirmView,
                context: undefined,
                template: template,
                okCloses: true,
                title: title.trim(),
                okText: okText,
                cancelText: cancelText,
                dialogClass: "modal-md",
                allowCancel: true,
                animate: true,
                focusOk: true,
                modalOptions: {
                    backdrop: 'static',
                    keyboard: false
                }
            }, dialogProps)).open(function () {
                if (_.isFunction(okCallback)) {
                    okCallback.apply(confirmView, arguments);
                }
            }).on("cancel", function () {
                if (_.isFunction(cancelCallback)) {
                    cancelCallback.apply(confirmView, arguments);
                }
            });
        });

    },
    showModalBackboneView: function (view, titlePrefix, successCallback, readonly, contextData, dialogProps) {
        TemplateManager.get("modal-template", function (template) {
            if (!titlePrefix) {
                titlePrefix = "";
            }

            var modal = new Backbone.BootstrapModal(_.extend({
                content: view,
                context: contextData || undefined,
                template: template,
                okCloses: !!readonly,
                title: titlePrefix.trim() + " " + (view.options.meta.labelRP ? view.options.meta.labelRP.toLowerCase() : ""),
                okText: (readonly) ? "Ok" : "Сохранить",
                cancelText: "Отмена",
                dialogClass: "modal-lg",
                allowCancel: !readonly,
                animate: true,
                focusOk: false,
                modalOptions: {
                    backdrop: 'static',
                    keyboard: false
                }
            }, dialogProps)).open(function () {
                if (readonly) {
                    return;
                }

                var errorsInfoBlock = view.$(".errors-info-block");
                errorsInfoBlock.css("display", "none");

                view.save(function (model, response, options) {
                    modal.close();

                    //Инициализируем текст сообщения
                    var display = Utils.getDisplay(model.toJSON(), view.options.meta.display, view.options.meta);
                    if (display) {
                        display = ": " + display;
                    }

//                    _toastr("Успешное сохранение " + display.trim(), "top-right", "success", false);
                    _toastr("Успешное сохранение " + (view.options.meta.labelRP ? view.options.meta.labelRP.toLowerCase() : "") + display,
                            "top-right", "success", false);
                    if (_.isFunction(successCallback)) {
                        successCallback.apply(this, arguments);
                    }
//                    view.trigger('view-signal', {type: "save", data: model.toJSON()});
                }, function (model, xhr, options) {
                    view.setError(xhr.responseJSON);

                    var message = Utils.getObjectValue(xhr, "responseJSON.error");
                    if (message) {
                        $(".errors-info-block-content", errorsInfoBlock).html("<p style='font-size: 14px'>" + message + "</p>");
                        errorsInfoBlock.css("display", "block");

                        console.error(message, xhr);
                        //Если не мобильное разрешение
                        if (!TemplateManager.checkListResolution()) {
                            _toastr(message, "top-right", "error", false);
                        }
                    } else {
                        _toastr("Ошибка сохранения " + (view.options.meta.labelRP ? view.options.meta.labelRP.toLowerCase() : ""),
                                "top-right", "error", false);
                    }
                });
            }).on("cancel", function () {
                if (Utils.getObjectValue(view, "model.cacheModel")) {
                    view.model.set(view.model.cacheModel);
                }
            });
        });
    },
    showSimpleModalBackboneView: function (view, titlePrefix, successCallback, contextData, dialogProps, cancelCallback) {
        TemplateManager.get("modal-template", function (template) {
            if (!titlePrefix) {
                titlePrefix = "";
            }

            var modal = new Backbone.BootstrapModal(_.extend({
                content: view,
                context: contextData || undefined,
                template: template,
                okCloses: false,
                title: titlePrefix.trim(),
                okText: "Ок",
                dialogClass: "modal-lg",
                animate: true,
                allowCancel: false,
                focusOk: false,
                closeOnOk: true,
                modalOptions: {
                    backdrop: 'static',
                    keyboard: false
                }
            }, dialogProps)).open(function () {
                if (modal.options.closeOnOk !== false) {
                    modal.close();
                }

                if (_.isFunction(successCallback)) {
                    successCallback.apply(this, arguments);
                }
            }).on("cancel", function () {
                if (_.isFunction(cancelCallback)) {
                    cancelCallback.apply(arguments);
                }
            });
        });
    },
    showOverlayModalBackboneView: function (view, afterInit, contextData, dialogProps) {
        TemplateManager.get("modal-overlay-template", function (template) {
            var modal = new Backbone.BootstrapModal(_.extend({
                content: view,
                context: contextData || undefined,
                template: template,
                okCloses: false,
                title: "",
                okText: "Ок",
                dialogClass: "modal-full",
                animate: true,
                allowCancel: false,
                showFooter: false,
                focusOk: false,
                modalOptions: {
                    backdrop: 'static',
                    keyboard: false
                }
            }, dialogProps)).open(function () {
                modal.close();
            });
            
            if(view instanceof DocumentContextMenu) {
                view.modal = modal;
            }
            
            //Если задана функция afterInit, то после инициализации модали, вызываем ее в контексте 
            //view с переданной модайлью в качестве параметра
            //Может использоваться например для закрытия модали по определенному пользователем событию
            if (_.isFunction(afterInit)) {
                afterInit.call(view, modal);
            }           
        });
    },
    /**
     * Возвращает представление объекта по его данным
     * @param {type} data данные объекта
     * @param {type} display структура представления объекта
     * @param {type} мета информация об объекте
     * @return представление объекта
     */
    getDisplay: function (data, display, meta) {
        var result = "";
        if (!data) {
            return result;
        }
//        if (!display || !display.fields) {
//            display = meta.display;
//        }
        if (!display || !display.fields) {
            return result;
        }
        var sep = "";
        if (display.sep) {
            sep = display.sep;
        }

        for (var i = 0; i < display.fields.length; i++) {
            //получили поле, получили значение поля
            var field = display.fields[i];

            var name_field = field.name;

            var value_field = Utils.getObjectValue(data, name_field);

            if (_.isObject(value_field)) {
                value_field = Utils.getDisplay(value_field, Meta.getFieldByName(meta, name_field).relation.display, meta);

                if (!value_field) {
                    var subMeta = Meta[Meta.getFieldByName(meta, name_field).relation.object];
                    value_field = Utils.getDisplay(Utils.getObjectValue(data, name_field), subMeta.display, subMeta);
                }
            }

            //Если задан объект meta, пытаемся отформатировать поле в соответствии с типом
            var metaField = Meta.getFieldByName(meta, name_field);
            if (metaField && metaField.type) {
                value_field = Utils.getFormatFieldValueTableView(value_field, metaField.type, metaField);
            }

            if (value_field) {
                result += ((field.prefix) || "") + value_field + ((field.suffix) || "");

                if (i < display.fields.length - 1) {
                    result += sep;
                }
            }
        }
        return result;
    },    
    /**
     * Возвращает поля DisplayFields
     * @param {type} display структура представления объекта
     * @param {type} meta информация об объекте
     * @param {type} parent родительский объект конкатенируется к текущему полю через точку
     * @param {type} result итоговый массив полей
     * @return массив полей
     */
    getSortingDisplayFields: function (display, meta, parent, result) {
        result = result || [];
        parent = parent || "";
        if (!display || !display.length || !meta) {
            return result;
        }

        for (var i = 0; i < display.length; i++) {
            var field = display[i];
            
            if(!field.sorting) {
                continue;
            }
            
            var name_field = field.name;
            var metaField = Meta.getFieldByName(meta, name_field);
            
            if(parent) {
                name_field = parent + "." + name_field;
            }
            if(Utils.getObjectValue(metaField, "relation.object") && Meta[metaField.relation.object]) {
                var fieldMeta = Meta[metaField.relation.object];
                Utils.getSortingDisplayFields(metaField.relation.display || fieldMeta.display, fieldMeta, name_field, result);
            } else {
                result.push(name_field);
            }
        }
        return result;
    },    
    typeIsNumber: function (type) {
        return (type === "int" ||
                type === "integer" ||
                type === "long" ||
                type === "double" ||
                type === "bigdecimal");
    },
    /**
     * Извлекает значение поля для отображения в таблице
     * @return 
     */
    getFormatFieldValueTableView: function (data, type, meta) {
        if (type === "boolean") {
            var trueValue = Utils.getObjectValueOrDefault(meta, "booleanPresenter.trueValue", "Да");
            var falseValue = Utils.getObjectValueOrDefault(meta, "booleanPresenter.falseValue", "Нет");
            return data ? trueValue : falseValue;
            //return data ? "<span style='font-weight: 600;'>"+trueValue+"</span>" : "<span>"+falseValue+"</span>";
        }
        
        if (!data) {
            return '';
        }

        if (type === "timestamp" || type == "localdatetime") {
            var mDate = moment(data);
            if (mDate && mDate.isValid()) {
                return mDate.format("DD.MM.YYYY HH:mm:ss");
            }
        } else if (type === "date" || type == "localdate") {
            var mDate = moment(data);
            if (mDate && mDate.isValid()) {
                return mDate.format("DD.MM.YYYY");
            }
        } else if (type === "time" || type === "localtime") {
            var mDate = '';
            if (data.length <= 8) {
                mDate = moment(data, "HH:mm:ss");
            } else if (data.length > 8) {
                mDate = moment(data);
            }

            if (mDate && mDate.isValid()) {
                return mDate.format("HH:mm:ss");
            }
        } else if (type === "int" ||
                type === "integer" ||
                type === "long") {
            return Utils.priceFormat(data);
        } else if (type === "double" ||
                type === "bigdecimal") {
            return Utils.priceFormat(data, 2);
        } else {
            return data;
        }

        return '';
    },
    /**
     *Вычисляет символьный номер колонки по числовому, подобно тому как нумерует *колонки excel
     *return строка 
     */
    getColLiterStrByIndex: function (index) {
        var result = "";
        var prev = parseInt(index / 26);
        var currentLitera = (index % 26) + 1
        if (!result) {
            result = [];
        }

        if (prev > 0) {
            result = getColLiterStrByIndex(prev - 1);
        }

        result += String.fromCharCode(currentLitera + 64);
        return result;
    },
    /**
     *Вычисляет символьный номер колонки по числовому, подобно тому как нумерует *колонки excel
     *return массив символов 
     */
    getColLiterArrByIndex: function (index, result) {
        var prev = parseInt(index / 26);
        var currentLitera = (index % 26) + 1
        if (!result) {
            result = [];
        }

        if (prev > 0) {
            getColLiterArrByIndex(prev - 1, result);
        }

        result.push(String.fromCharCode(currentLitera + 64));
        return result;
    },
    /**
     * Форматирует число в формат цены
     * @param double price цена до форматирования
     * @param int precision точность
     * @return String
     */
    priceFormat: function (price, precision) {
        if (!price) {
            price = 0;
        }

        if (typeof (price) === "string") {
            price = Number.parseFloat(price.trim().replace(" ", "").replace(",", "."))
        }

        if (!precision) {
            precision = 0;
        }

        var format = "0,0";
        for (var i = 0; i < precision; i++) {
            if (i === 0) {
                format += ".";
            }
            format += "0";
        }
        return numeral(price).format(format);
    },
    /**
     * Возвращает форат числа для input mascked
     * @param int scale знаков до запятой
     * @param int precision точность
     * @return String
     */
    getFormat: function (scale, precision) {
        if (!scale) {
            scale = 9;
        }

        if (!precision) {
            precision = 0;
        }

        var format = Array(scale + 1).join("9");
        if (precision) {
            format += "." + Array(precision + 1).join("9");
        }

        return format;
    },
    getPaginatorLinks: function (pageNumber, lastPage, showCount) {
        var middle = Math.floor(showCount / 2);

        //Левая граница
        var left = pageNumber - middle;
        //Правая граница
        var right = pageNumber + middle;

        //Определяем на сколько правая граница выходит за пределы количества элементов
        var rtc = right - lastPage;
        if (rtc > 0) {
            //Корректируем левую границу
            left -= rtc;
            //Корректируем правую границу
            right = lastPage;
        }

        //Определяем на сколько левая граница меньше 1
        var ltc = 1 + left;
        if (ltc <= 1) {
            //Корректируем правую границу
            right += 1 + Math.abs(left);
            if (right > lastPage) {
                right = lastPage;
            }
            //Корректируем левую границу
            left = 1;
        }

        return {
            start: left, 
            end: right, 
            pageNumber:pageNumber,
            showCount: showCount,
            lastPage: lastPage
        };
    }
};