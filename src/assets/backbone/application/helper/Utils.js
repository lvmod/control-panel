window.Utils = {
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
            var subObjects = subObject.split('.');
            //Перебираем под объекты
            for (var i = 0; i < subObjects.length; i++) {
                var index = subObjects[i].match(/\[.*\]/);
                var subObj = subObjects[i].replace(/\[.*\]/, "");

                if (subObj) {
                    var lastObj = subObj;
                    object = object[subObj];
                    if (object === undefined) {
                        //console.error("Ошибка получения объекта: " + subObject + "; Не удается найти свойство: " + "\"" + subObj + "\"");
                        return;
                    }

                    //Проверяем является ли под объект массивом
                    if (index) {
                        var rexp = /\[(\d+)\]|\[["|']([\wа-яА-ЯёЁ]+)["|']\]/g;
                        var matchArray;
                        //Поиск всех индексов для n-мерного массива
                        while ((matchArray = rexp.exec(index))) {
                            var matchIndex = matchArray[1] || matchArray[2];
                            if (matchIndex) {
                                object = object[matchIndex];
                                if (object === undefined) {
                                    //console.error("Ошибка получения объекта: " + subObject + "; Не существует элемента с индексом: \"" + matchIndex + "\" в объекте: " + lastObj);
                                    return;
                                }
                            } else {
                                //console.error("Ошибка получения объекта: " + subObject + "; Не могу получить указанный объект. Ошибка получения индекса элемента.");
                                return;
                            }
                        }
                    }
                } else {
                    //console.error("Ошибка получения объекта: " + subObject + "; Не могу получить указанный объект.");
                    return;
                }
            }
        }
        return object;
    },

    //Установка значения объекта. object - сам объект, subObject - строка содержащая описание подъобъекта, 
    //value - новое значение.
    setObjectValue: function (object, subObject, value) {
        //Если присутствуют под объекты.
        var data = object;
        var lastObject = object;
        var lastObj = "";
        if (object && subObject) {
            var subObjects = subObject.split('.');
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
                            object = object[subObj];
                        } else {
                            //console.error("Ошибка получения объекта: " + subObject + "; Не удается установить свойство: " + "\"" + subObj + "\"");
                            return data;
                        }
                    }

                    //Проверяем является ли под объект массивом
                    if (index) {
                        var rexp = /\[(\d+)\]|\[["|']([\wа-яА-ЯёЁ]+)["|']\]/g;
                        var matchArray;
                        //Поиск всех индексов для n-мерного массива
                        while ((matchArray = rexp.exec(index))) {
                            var matchIndex = matchArray[1] || matchArray[2];
                            if (matchIndex) {
                                lastObject = object;
                                object = object[matchIndex];
                                if (object === undefined) {
                                    //console.error("Ошибка получения объекта: " + subObject + "; Не существует элемента с индексом: \"" + matchIndex + "\" в объекте: " + lastObj);
                                    return data;
                                }
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
            if (lastObject && lastObj && lastObject[lastObj]) {
                lastObject[lastObj] = value;
            }
        } else {
            data = value;
        }
        return data;
    },
    showModalBackboneView: function (view, titlePrefix, successCallback) {
        TemplateManager.get("modal-template", function (template) {
            if (!titlePrefix) {
                titlePrefix = "";
            }

            var cacheModel = view.model.toJSON();

            var modal = new Backbone.BootstrapModal({
                content: view,
                template: template,
                okCloses: false,
                title: titlePrefix.trim() + " " + (view.options.meta.labelRP ? view.options.meta.labelRP.toLowerCase() : ""),
                okText: "Сохранить",
                cancelText: "Отмена",
                dialogClass: "modal-lg",
                animate: true,
                modalOptions: {
                    backdrop: 'static',
                    keyboard: false
                }
            }).open(function () {
                view.model.save(undefined, {
                    success: function (model, response, options) {
                        modal.close();
                        _toastr("Успешное сохранение " + (view.options.meta.labelRP ? view.options.meta.labelRP.toLowerCase() : ""),
                                "top-right", "success", false);

                        if (_.isFunction(successCallback)) {
                            successCallback.apply(this, arguments);
                        }
                    }, error: function (model, xhr, options) {
                        view.setError(xhr.responseJSON);
                        _toastr("Ошибка сохранения " + (view.options.meta.labelRP ? view.options.meta.labelRP.toLowerCase() : ""),
                                "top-right", "error", false);
                    }
                });
            }).on("cancel", function () {
                view.model.set(cacheModel);
            });
        });
    }
};