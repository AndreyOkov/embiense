(function ($) {
    function JqueryValidate(element, options) {
        this.element = element;
        this.options = options;
        this.submit = options.submit;
        var self = this;
        // конструктор блокирует дефолтное поведение кнопки и вызывает метод validate данного объекта

        this.element.on("submit", function (e) {
            e.preventDefault(); //блокирует дефолтное поведение кнопки SUBMIT
            self.validate();    //вызываем метод валидации
        });
        if (this.submit) self.validate();
    }

    JqueryValidate.prototype.validate = function () {
        var formData = this.element.serializeArray(),   //возвращает массив объектов JavaScropt, который можно передовать в формате JSON.
            formDataObject = {},
            selects = [],                                //для успешной сериализации элемент формы должен содержать атрибут name
            regexp = /[\[][\]]/,
            self = this;
        console.log('create submit =' + this.submit);

        // создаем ассоциативный массив из объкетов содержащихся в formData
        $.each(formData, function (key, value) {
            if (value.name.search(regexp) > 0) {
                value.name = value.name.substr(0, value.name.length - 2);
                if (!selects[value.name]) {
                    selects[value.name] = [];
                }
                selects[value.name].push(value.value);
            }
            formDataObject[value.name] = value.value;
        });
        for (var i in selects) {
            formDataObject[i] = selects[i];
        }
        //передаемм этот объект в формате json методом post через ajax
        $.ajax(self.options.url, {
            method: "post",
            data: {
                formData: formDataObject
            },
            success: function (results) {  //переменная result содержит данные которые вернет php - скрипт
                self.handleAjax(results); //метод данного объекта который будет вызвн после прохождения валидации и будет содержать либо ошибки
            },
            dataType: "json"
        });
    };

    JqueryValidate.prototype.handleAjax = function (results) { // в result данные которые вернет php - скрипт

        var self = this;
        if (results[0] === true) {
            if (!self.submit) {
                self.clearValidationMessages();
            }
            self.options.validateCallback();
        }
        else {
            if (!self.submit) {
                self.errors = results[1];
                self.showValidationMessages();
            }
        }

    };

    JqueryValidate.prototype.showValidationMessages = function () {
        var self = this;

        self.clearValidationMessages();
        $.each(self.errors, function (inputKey, errorMessages) {
            if (errorMessages && errorMessages.length > 0) {
                self.element.find("[name=" + inputKey + "]").siblings(self.options.errorContainer)
                    .html("<p class='text-danger'>" + errorMessages[0] + "</p>");
            }
        });
    };

    JqueryValidate.prototype.clearValidationMessages = function () {
        this.element.find(this.options.errorContainer).html('');
    };

    $.fn.jqueryValidate = function (options) {
        new JqueryValidate(this, options);  //this = ("form'), создаем новый объект который описан выше
        return this;
    }
})(jQuery);