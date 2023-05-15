<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Service\OneSignalService;
use App\Entities\PushNoti;
use App\Entities\UserLogin;
use App\Entities\User;

class PushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userId;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId, $data)
    {
        $this->userId = $userId;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->userId);
        $onesignal = new OneSignalService();

        if ( ! is_null($user)) {
            $response = $onesignal->send($user->getPlayerIds(), $this->data);
            $response = json_decode($response, true);
            PushNoti::create(array_merge(
                ['user_id' => $this->userId],
                ['response' => $response],
                $this->data->toArray()
            ));

            try {
                if (array_key_exists('errors', $response) && is_array($response['errors']) &&
                    array_key_exists('invalid_player_ids', $response['errors'])) {
                    UserLogin::where('user_id', $this->userId)
                        ->whereIn('device_token', $response['errors']['invalid_player_ids'])
                        ->delete();
                }
            } catch (\Exception $e) {

            }
        }
    }
}
