<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Service\OneSignalService;
// use App\Service\NotificationService;
use Illuminate\Support\Collection;
use App\Entities\User;

class SinglePushJob implements ShouldQueue
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
      // $service = new NotificationService();
      $onesignal = new OneSignalService();

      if ( ! is_null($user)) {

          foreach ($user->getPlayerIds() as $key => $playerId) {
            $onesignal->send([$playerId], $this->data);
          }

          // $tokens = $user->getDeviceTokens();
          // foreach ($tokens->get('ios') as $key => $token) {
          //
          //   $item = collect([
          //       'android' => collect(),
          //       'ios' => collect([$token]),
          //   ]);
          //   $service->send($this->data, $item);
          // }
          //
          // foreach ($tokens->get('android') as $key => $token) {
          //
          //   $item = collect([
          //       'android' => collect([$token]),
          //       'ios' => collect(),
          //   ]);
          //   $service->send($this->data, $item);
          // }
      }
    }
}
