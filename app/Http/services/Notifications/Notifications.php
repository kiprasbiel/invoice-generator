<?php


namespace App\Http\services\Notifications;


trait Notifications
{
    public function newNotification($text, $type = 'success', $timeout = 3000, $theme = 'sunset', $layout = 'topRight'){
        return [
            'type' => $type,
            'text' => $text,
            'timeout' => $timeout,
            'theme' => $theme,
            'layout' => $layout,
        ];


    }
}
