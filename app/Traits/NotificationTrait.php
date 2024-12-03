<?php

namespace App\Traits;

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

    public function sendMessage($userTokens, $title, $body, $data = [])
    {
        $client = $this->registerAuth();

        foreach ($userTokens as $token) {
            $client->post("https://fcm.googleapis.com/v1/projects/cisot-udayana/messages:send", [
                'json' => [
                    'message' => [
                        'token' => $token,
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
        }
    }
}