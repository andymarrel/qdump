<?php

class AuthController extends BaseController {
    public function indexAction(){
        return View::make('auth.auth');
    }

    public function registerAction(){
        return View::make('auth.register');
    }

    public function postRegisterAction(){
        $result = false;
        $errors = [];

        // Handling registration request
        if (Input::has('sent')) {
            $rules = [
                'email' => 'required|email',
                'password' => 'required|min:6',
                'password_again' => 'required|same:password',
                'captcha' => 'required|captcha'
            ];

            $messages = [
                'email.required' => 'Это поле необходимо заполнить',
                'email.email' => 'Неверный адрес электронной почты',
                'password.required' => 'Это поле необходимо заполнить',
                'password.min' => 'Пароль должен состоять из 6 символов или более',
                'password_again.required' => 'Это поле необходимо заполнить',
                'password_again.same' => 'Пароли не совпадают',
                'captcha.required' => 'Это поле необходимо заполнить',
                'captcha.captcha' => 'Картинка введена неверно'
            ];

            $validator = Validator::make(Input::all(), $rules, $messages);

            if ($validator->fails()) {
                $errorMessages = $validator->messages();
                if ($errorMessages->has('email')){
                    $errors['email'] = $errorMessages->first('email');
                }
                if ($errorMessages->has('password')){
                    $errors['password'] = $errorMessages->first('password');
                }
                if ($errorMessages->has('password_again')){
                    $errors['password_again'] = $errorMessages->first('password_again');
                }
                if ($errorMessages->has('captcha')){
                    $errors['captcha'] = $errorMessages->first('captcha');
                }
            } else {
                // Trying to register new users
                try {
                    $user = Sentry::createUser([
                        'email' => Input::get('email'),
                        'password' => Input::get('password')
                    ]);

                    $membersGroup = Sentry::findGroupByName('Member');

                    $user->addGroup($membersGroup);

                    $activationCode = $user->getActivationCode();

                    /**
                     * @todo Create new template for email
                     */
                    Mail::send('emails.registration', ['id' => $user->id, 'code' => $activationCode], function($message) use ($user){
                        $message->to($user->email)
                            ->subject('Завершение регистрации в сервисе Qdump');
                    });
                } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
                    $errors['email'] = 'Неверный адрес электронной почты';
                } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
                    $errors['password'] = 'Пароль должен состоять из 6 символов или более';
                } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
                    $errors['email'] = 'Пользователь с такой электронной почтой уже зарегистрирован';
                } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
                    //$errors[] = 'Группа пользователей не найдена';
                }
            }

            if (empty($errors)) {
                $result = true;
            }
        }

        return Response::json([
            'result' => $result,
            'errors' => $errors
        ]);
    }

    public function postLoginAction(){
        $result = false;
        $errors = [];

        if (Input::has('sent')) {
            $rules = [
                'email' => 'required|email',
                'password' => 'required|min:6',
                'remember' => 'required|in:true,false',
                'captcha' => 'required|captcha'
            ];

            $messages = [
                'email.required' => 'Это поле необходимо заполнить',
                'email.email' => 'Неверный адрес электронной почты',
                'password.required' => 'Это поле необходимо заполнить',
                'password.min' => 'Пароль должен состоять из 6 символов или более',
                'remember.required' => 'Неверное значение',
                'remember.in' => 'Неверное значение',
                'captcha.required' => 'Это поле необходимо заполнить',
                'captcha.captcha' => 'Картинка введена неверно'
            ];

            $validator = Validator::make(Input::all(), $rules, $messages);

            if ($validator->fails()){
                $errorMessages = $validator->messages();

                if ($errorMessages->has('email')){
                    $errors['email'] = $errorMessages->first('email');
                }
                if ($errorMessages->has('password')){
                    $errors['password'] = $errorMessages->first('password');
                }
                if ($errorMessages->has('remember')){
                    $errors['remember'] = $errorMessages->first('remember');
                }
                if ($errorMessages->has('captcha')){
                    $errors['captcha'] = $errorMessages->first('captcha');
                }
            } else {
                try {
                    $credentials = [
                        'email' => Input::get('email'),
                        'password' => Input::get('password'),
                        'social_provider' => null,
                        'social_uid' => null
                    ];

                    $remember = (Input::get('remember') == "true") ? true : false;

                    $user = Sentry::authenticate($credentials, $remember);
                } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
                    $errors['password'] = 'Пароль неверный, попробуйте ещё раз';
                } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                    $errors['email'] = 'Пользователь не найден';
                } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                    $errors['email'] = 'Аккаунт не активирован';
                } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
                    $errors['email'] = 'Пользователь временно заморожен';
                } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
                    $errors['email'] = 'Пользователь заблокирован';
                }
            }

            if (empty($errors)){
                $result = true;
            }
        }

        return Response::json([
            'result' => $result,
            'errors' => $errors
        ]);
    }

    public function socialAuthAction($provider){
        if (array_key_exists($provider, Sociauth::getActiveProviders())){
            $socialProvider = Sociauth::getProvider($provider);
            $code = Input::get('code');

            if ($socialProvider->authenticate($code)) {
                $socialUser = $socialProvider->getUserProvider();
                if ($socialUser->getId() !== false && filter_var($socialUser->getEmail(), FILTER_VALIDATE_EMAIL)){
                    $uid = $socialUser->getId();
                    $email = $socialUser->getEmail();

                    /**
                     * Linking account if user is logged in
                     */
                    if (Sentry::check()) {
                        $user = Sentry::getUser();

                        // If user authorized through social network
                        if ($user->isSocialAccount()) {
                            return $this->redirectWithNotification('Пользователи вошедшие через соц. сеть не могут привязать аккаунт', 'error', '/settings/accounts');
                        }

                        // If user already linked this network
                        if ($user->hasLinkedAccount($provider)){
                            return $this->redirectWithNotification('Сначала отвяжите ваш прежний аккаунт', 'error', '/settings/accounts');
                        }

                        // This social account already linked
                        if (SocialLink::findByProviderAndSocialId($provider, $uid) !== null) {
                            return $this->redirectWithNotification('Этот аккаунт уже привязан к другой учётной записи', 'error', '/settings/accounts');
                        }

                        // Creating new link
                        $socialLink = new SocialLink;
                        $socialLink->user_id = $user->id;
                        $socialLink->provider = $provider;
                        $socialLink->social_id = $uid;
                        $socialLink->save();

                        // Redirecting with success
                        return $this->redirectWithNotification('Аккаунт успешно привязан!', '', '/settings/accounts');
                    }

                    $socialLink = SocialLink::findByProviderAndSocialId($provider, $uid);

                    // If social accound is linked to qdump account,
                    // authorizing qdump account
                    if ($socialLink !== null) {
                        // Authorized linked account
                        Sentry::login(Sentry::findUserById($socialLink->user_id));

                        // Redirecting with success
                        return $this->redirectWithNotification('Вы успешно вошли в систему!');
                    }

                    $user = User::whereRaw('social_provider = ? AND social_uid = ?', [
                        $provider,
                        $uid
                    ])->first();

                    /**
                     * If we already have this registered user with data from social network,
                     * than logging in as social account and updating email:
                     *
                     * If not, creating new user and logging in
                     */
                    if ($user !== null) {
                        // Updating email
                        if ($user->email != $email) {
                            $user->email = $email;
                            $user->save();
                        }

                        // Logging in
                        Sentry::login(Sentry::findUserById($user->id));

                        // Redirecting with success
                        return $this->redirectWithNotification('Вы успешно вошли в систему!');
                    } else {
                        $user = User::where('email', '=', $email)->first();
                        if ($user !== null) {
                            // User with this email already registered
                            return $this->redirectWithNotification('Пользователь с такой электронной почтой уже зарегистрирован', 'error');
                        } else {
                            // Creating new user
                            $user = Sentry::createUser([
                                'email' => $email,
                                'password' => md5(uniqid() . mt_rand(0, 1000000)),
                                'social_uid' => $uid,
                                'social_provider' => $provider,
                                'activated' => true
                            ]);

                            $membersGroup = Sentry::findGroupByName('Member');

                            $user->addGroup($membersGroup);

                            // Logging him in
                            Sentry::login($user);

                            // Redirecting with success
                            return $this->redirectWithNotification('Вы успешно вошли в систему!');
                        }
                    }
                }
            } else {
                return $this->redirectWithNotification('Произошла неизвестная ошибка', 'error');
            }
        }
    }

    public function logoutAction(){
        Sentry::logout();

        return $this->redirectWithNotification('Вы успешно вышли из системы!');
    }

    public function passwordRecoveryAction() {
        return View::make('auth.recovery');
    }

    public function postRecoveryAction() {
        $result = false;
        $email = Input::get('email');
        $errors = [];

        $messages = [
            'email.required' => 'Это поле необходимо заполнить',
            'email.email' => 'Неверный адрес электронной почты',
            'captcha.required' => 'Это поле необходимо заполнить',
            'captcha.captcha' => 'Картинка введена неверно'
        ];

        $rules = [
            'email' => 'required|email',
            'captcha' => 'required|captcha'
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()){
            $errorMessages = $validator->messages();
            if ($errorMessages->has('email')){
                $errors['email'] = $errorMessages->first('email');
            }
            if ($errorMessages->has('captcha')) {
                $errors['captcha'] = $errorMessages->first('captcha');
            }
        } else {
            try {
                $user = Sentry::findUserByLogin($email);
                $resetCode = $user->getResetPasswordCode();

                Mail::send('emails.recovery_step_1', ['code' => $resetCode, 'userId' => $user->id], function($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Восстановление пароля в сервисе Qdump.ru');
                });
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                $errors['email'] = 'Пользователь не найден';
            }
        }

        if (empty($errors)){
            $result = true;
        }

        return Response::json([
            'result' => $result,
            'errors' => $errors
        ]);
    }

    public function postRecoveryResetAction($userId, $code) {
        try {
            // Find the user using the user id
            $user = Sentry::findUserById($userId);

            // Check if the reset password code is valid
            if ($user->checkResetPasswordCode($code)) {
                // Attempt to reset the user password
                $randomPassword = $this->generateRandomString();
                if ($user->attemptResetPassword($code, $randomPassword)) {
                    Mail::send('emails.recovery_step_2', ['password' => $randomPassword], function($message) use ($user) {
                        $message->to($user->email)
                            ->subject('Восстановление пароля в сервисе Qdump.ru');
                    });
                    return $this->redirectWithNotification('Новый пароль отправлен на ваш электронный адрес', '', '/auth');
                } else {
                    return $this->redirectWithNotification('Не удалось изменить пароль', 'error');
                }
            } else {
                return $this->redirectWithNotification('Не удалось изменить пароль', 'error');
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            echo 'User was not found.';
        }
    }

    protected function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function activateAction($userId, $code) {
        try {
            $user = Sentry::findUserById((int)$userId);

            if ($user->attemptActivation($code)){
                Sentry::login($user);
                return $this->redirectWithNotification('Активация прошла успешно!');
            } else {
                return $this->redirectWithNotification('Активация не удалась', 'error');
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return $this->redirectWithNotification('Пользователь не найден', 'error');
        } catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e) {
            return $this->redirectWithNotification('Пользователь уже активирован', 'error');
        }
    }

    public function captchaRefreshAction() {
        return URL::to('captcha?' . mt_rand(100000, 999999));
    }
} 