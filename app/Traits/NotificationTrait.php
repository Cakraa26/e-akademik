<?php

namespace App\Traits;

use App\Models\Notification;
use Google\Client as GoogleClient;

trait NotificationTrait
{
    private function registerAuth()
    {
        $credentials = __DIR__ . '/../../google-firebase.json';
        $client = new GoogleClient();
        $client->setAuthConfig($credentials);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $httpClient = $client->authorize();
        return $httpClient;
    }

    public function sendMessage($users, $title, $body, $data = [], $pengumumanfk = null)
    {
        $client = $this->registerAuth();

        foreach ($users as $user) {
            $client->post("https://fcm.googleapis.com/v1/projects/cisot-udayana/messages:send", [
                'json' => [
                    'message' => [
                        'token' => $user->notif_token,
                        'notification' => [
                            'title' => $title,
                            'body' => $body
                        ],
                        'data' => [
                            'channelId' => 'default',
                            'message' => $title,
                            'title' => $body,
                            'body' => json_encode([
                                'title' => $title,
                                'body' => $body,
                            ]),
                            'scopeKey' => '@balisolutionbiz/CISOT',
                            'experienceId' => '@balisolutionbiz/CISOT',
                            ...$data
                        ]
                    ]
                ]
            ]);

            Notification::create([
                'residenfk' => $user->pk,
                'title' => $title,
                'body' => $body,
                'pengumumanfk' => $pengumumanfk
            ]);
        }
    }
}