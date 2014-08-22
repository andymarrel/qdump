<?php

class BaseController extends Controller {
    /**
     * @param string $notificationMessage
     * @param string $notificationType // Default type is success
     * @param string $redirectHref // By default returns to home page
     */
    protected function redirectWithNotification($notificationMessage, $notificationType = '', $redirectHref = '/'){
        return Redirect::to($redirectHref)->with('notification', [
            'type' => $notificationType,
            'message' => $notificationMessage
        ]);
    }

    /**
     * If user is not authorized, than redirecting to main with message
     *
     * @return mixed
     */
    protected function redirectToMainWithNeedAuthorizationMessage(){
        return Redirect::to('/')->with('notification', [
            'type' => 'error',
            'message' => 'Необходимо войти в систему'
        ]);
    }
}
