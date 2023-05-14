<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;

class DetectGasRefuel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const COUNT = 10;

    public $tries = 3;
    public $timeout = 20;

    /**
     * @var Collection
     */
    private $samples;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $samples)
    {
        $this->samples = $samples;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $diffs = collect();
        $slice_size = floor(self::COUNT / 2);
        for ($i = self::COUNT - 1; $i < $this->samples->count(); $i++) {
            $start = $i - self::COUNT + 1;
            $avg1 = $this->samples->slice($start, $slice_size)->avarage();
            $avg2 = $this->samples->slice($start + $slice_size, $slice_size)->avarage();
            $diffs->push($avg1 - $avg2);
        }

        $status = $diffs->reduce(function($carry, $item) {
            return $carry & ($item > 50);
        }, true);


    }

}
