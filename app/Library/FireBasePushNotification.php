<?php

namespace App\Library;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 *  FireBasePushNotification
 *  Author : XMHafiz
 */
class FireBasePushNotification
{
    public static function push($payload, $channelName)
    {
        self::pushToDevice('ios', $payload, $channelName);
        self::pushToDevice('android', $payload, $channelName);
    }

    private static function pushToDevice($osType, $payload, $channelName)
    {
        try {
            // set headers and body according to firebase docs
            // https://firebase.google.com/docs/cloud-messaging/server#implementing-http-connection-server-protocol

            $headers = [
                'Content-Type' => 'application/json',
                // auth key using enviroment variable
                'Authorization' => 'key=' . config('notification.fire_key'),
            ];

            // send request
            $body = [];

            if ($osType == 'android') {
                $body = [
                    'to' => '/topics/android/' . $channelName,
                    'priority' => 'high',
                    'data' => $payload,
                ];
            } elseif ($osType == 'ios') {
                $body = [
                    'to' => '/topics/ios/' . $channelName,
                    'priority' => 'high',
                    'notification' => $payload,
                ];
            }

            $client = new Client;

            $response = $client->request('POST', config('notification.fire_url'), [
                'headers' => $headers,
                'json' => $body
            ]);

            $responseData = json_decode($response->getBody());

            return [
                'data' => $responseData,
                'statusCode' => $response->getStatusCode()
            ];

        } catch (ClientException $e) {
            // handle request exception to firebase service here
            return [
                'statusCode' => $e->getCode(),
                'data' => $e->getResponse()->getBody()->getContents(), // content currently in html
            ];
        } catch (\Exception $e) {
            return [
                'statusCode' => $e->getCode(),
                'data' => $e->getMessage(),
            ];
        }
    }
}
