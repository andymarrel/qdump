qdump.controller('AuthController', function($scope){
    $scope.global = {
        validateEmail: function(email) {
            var emailRegExp = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
            return (email.match(emailRegExp) == null) ? false : true;
        },
        addSuccessMessage: function(elem, message) {
            $('<div class="alert alert-success" style="display: none;">'+message+'</div>')
                .appendTo(elem)
                .slideDown('slow');
        },
        addError: function(element, message){
            element.parent().addClass('has-error has-feedback');
            $('<span class="glyphicon glyphicon-remove form-control-feedback" rel="tooltip" data-toggle="tooltip" data-placement="right" data-title="'+message+'"></span>').insertAfter(element);
        },
        refreshCaptcha: function(){
            $.ajax('/captcha/refresh', {
                type: 'get',
                dataType: 'text',
                success: function(response){
                    $("#captcha-container").html('<img src="'+response+'" alt="Captcha">');
                },
                error: function(xhr, status, error){
                    console.log(error);
                }
            });
        }
    };
    $scope.registration = {
        register: function(event, data){
            $.ajax('/register', {
                type: 'post',
                dataType: 'json',
                data: {
                    email: data.email,
                    password: data.password,
                    password_again: data.passwordAgain,
                    captcha: data.captcha,
                    sent: true
                },
                beforeSend: function(){
                    qdump.global.addButtonLoadingState($("#send-registration-btn"));
                },
                complete: function(){
                    qdump.global.removeButtonLoadingState($("#send-registration-btn"), 'Зарегистрироваться');
                },
                success: function(response){
                    $scope.registration.removeSuccessAlert();
                    $scope.registration.removeErrors();
                    $scope.global.refreshCaptcha();

                    if (response.result === true) {
                        $scope.registration.emptyForm();
                        $scope.global.addSuccessMessage($("#registartion-status"), '<strong>Регистрация прошла успешно!</strong> Чтобы завершить регистрацию, пройдите по ссылке, которую мы отправили на указанный вами электронный адрес.');
                    } else {
                        var errors = response.errors,
                            emailElem = $("#email"),
                            passElem = $("#password"),
                            passAgainElem = $("#password-again"),
                            captchaElem = $("#captcha");

                        if (errors.hasOwnProperty('email')) {
                            $scope.global.addError(emailElem, errors.email);
                        }

                        if (errors.hasOwnProperty('password')) {
                            $scope.global.addError(passElem, errors.password);
                        }

                        if (errors.hasOwnProperty('password_again')) {
                            $scope.global.addError(passAgainElem, errors.password_again);
                        }

                        if (errors.hasOwnProperty('captcha')) {
                            $scope.global.addError(captchaElem, errors.captcha);
                        }
                    }
                }
            });
        },
        removeErrors: function(){
            $("#email, #password, #password-again, #captcha").parent().removeClass('has-error has-feedback');
            $("span.form-control-feedback").remove();
        },
        removeSuccessAlert: function(){
            $("#registartion-status > div").slideUp('slow', function(){ $(this).remove();});
        },
        emptyForm: function(){
            $("#email, #password, #password-again, #captcha").val('');
        }
    };
    $scope.auth = {
        authenticate: function(event, data){
            event.preventDefault();
            $scope.global.refreshCaptcha();
            $scope.auth.removeErrors();
            
            $.ajax('/login', {
                type: 'post',
                dataType: 'json',
                data: {
                    sent: true,
                    email: data.email,
                    password: data.password,
                    remember: data.remember,
                    captcha: data.captcha
                },
                success: function(response) {
                    if (response.result === true) {
                        $scope.auth.emptyForm();

                        $('<div class="alert alert-success" style="display: none;"><strong>Вы успешно вошли в систему!</strong> Через несколько секунд вас перенаправит на главную страницу. Если этого не произошло - нажмите <a href="/">здесь</a>.</div>')
                            .appendTo($("#auth-status"))
                            .slideDown('slow');

                        setTimeout(function(){
                            document.location = '/';
                        }, 2000);
                    } else {
                        var emailElem = $("#email"),
                            passElem = $("#password"),
                            captchaElem = $("#captcha");

                        if (response.errors.hasOwnProperty('email')){
                            $scope.global.addError(emailElem, response.errors.email);
                        }
                        if (response.errors.hasOwnProperty('password')){
                            $scope.global.addError(passElem, response.errors.password)
                        }
                        if (response.errors.hasOwnProperty('captcha')){
                            $scope.global.addError(captchaElem, response.errors.captcha)
                        }
                    }
                }
            });
        },
        emptyForm: function(){
            $("#email, #password, #captcha").val('');
        },
        removeErrors: function(){
            $("#email, #password, #captcha").parent().removeClass('has-error has-feedback');
            $("span.form-control-feedback").remove();
        }
    };
    $scope.recovery = {
        sendToken: function(event, data){
            event.preventDefault();
            $scope.recovery.removeErrors();
            $scope.global.refreshCaptcha();

            var emailElem = $("#email"),
                captchaElem = $("#captcha"),
                token = $('[name="_token"]').val(),
                errors = false;

            if (!$scope.global.validateEmail(data.email)) {
                $scope.global.addError(emailElem, 'Неверный адрес электронной почты');
                errors = true;
            }

            if (data.captcha == '') {
                $scope.global.addError(captchaElem, 'Это поле необходимо заполнить');
                errors = true;
            }

            if (!errors) {
                $.ajax('/recovery/post', {
                    type: 'post',
                    dataType: 'json',
                    data: {
                        email: data.email,
                        captcha: data.captcha
                    },
                    beforeSend: function(request) {
                        qdump.global.addButtonLoadingState($("#send-recovery-btn"));
                        return request.setRequestHeader('X-CSRF-Token', token);
                    },
                    complete: function() {
                        qdump.global.removeButtonLoadingState($("#send-recovery-btn"), 'Продолжить');
                    },
                    success: function (response) {
                        $scope.recovery.removeSuccessMessage();

                        if (response.result === false) {
                            var errors = response.errors;

                            if (errors.hasOwnProperty('email')) {
                                $scope.global.addError(emailElem, errors.email);
                            }

                            if (errors.hasOwnProperty('captcha')) {
                                $scope.global.addError(captchaElem, errors.captcha);
                            }
                        } else {
                            $scope.recovery.emptyForm();

                            $scope.global.addSuccessMessage($("#recovery-status"), '<strong>Восстановление пароля прошло успешно!</strong> Письмо с дальнейшими инструкциями отправлено на указанный электронный адрес.');
                        }
                    }
                });
            }
        },
        emptyForm: function(){
            $("#email, #captcha").val('');
        },
        removeSuccessMessage: function(){
            $("#recovery-status").html('');
        },
        removeErrors: function(){
            $("#email, #captcha").parent().removeClass('has-error has-feedback');
            $("span.form-control-feedback").remove();
        }
    };
});