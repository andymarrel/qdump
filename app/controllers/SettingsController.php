<?php

class SettingsController extends BaseController {
    public function indexAction(){
        return View::make('settings/settings');
    }

    public function accountsAction(){
        return View::make('settings/accounts');
    }

    public function unlinkAction($provider) {
        $providers = Sociauth::getActiveProviders();

        if (array_key_exists($provider, $providers)){
            $user = Sentry::getUser();
            if ($user->hasLinkedAccount($provider)){
                $user->unlinkAccount($provider);
                return $this->redirectWithNotification('Аккаунт успешно отвязан!', '', '/settings/accounts');
            }
        }

        return $this->redirectWithNotification('Не удалось отвязать аккаунт', 'error', '/settings/accounts');
    }
} 