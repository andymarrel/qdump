<?php

class TestController extends BaseController {
    public function indexAction(){
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_again' => 'required|same:password'
        ];

        $messages = [
            'email.required' => 'Поле "адрес электронной почты" необходимо',
            'email.email' => 'Неверный адрес электронной почты',
            'password.required' => 'Поле "пароль" необходимо',
            'password.min' => 'Пароль должен состоять как минимум из 6 символов',
            'password_again.required' => 'Поле "пароль ещё раз" необходимо',
            'password_again.same' => 'Пароли не совпадают'
        ];

        $v = Validator::make([
            'email' => 'andym',
            'password' => '',
            'password_again' => ''
        ], $rules, $messages);

        if ($v->fails()){
            $messages = $v->messages();
            if ($messages->has('email')){
                echo $messages->first('email');
            }
            var_dump($messages);
        }
    }
} 