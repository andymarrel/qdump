<?php

class SettingsController extends BaseController {
    public function indexAction(){
        if (!Sentry::check()){
            return Redirect::to('/')->with('notification', [
                'type' => 'error',
                'message' => 'Необходимо войти в систему'
            ]);
        }
        return View::make('settings/settings');
    }

    public function accountsAction(){
        return View::make('settings/accounts');
    }

    public function unlinkAction($provider) {
        if (!Sentry::check()){
            return $this->redirectToMainWithNeedAuthorizationMessage();
        }

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