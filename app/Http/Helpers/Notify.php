<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\Redis;

class Notify{
    static function send(string $channel, string $user_id, array $message, string $event = 'new-message')
    {
        $redis = Redis::connection();
        return $redis->publish($channel,  json_encode([
            'message' => $message,
            'event' => $event,
            'subscriber_id' => $user_id
        ]));
    }
}
