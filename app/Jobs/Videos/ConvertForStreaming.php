<?php

namespace App\Jobs\Videos;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Format\Video\X264;

class ConvertForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;
    public $lastPerc = 0;

    /**
     * Create a new job instance.
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        

        $low = (new X264())->setKiloBitrate('250');
        $medium = (new X264())->setKiloBitrate('500');
        $high = (new X264())->setKiloBitrate('750');
        $HD = (new X264())->setKiloBitrate('1500');

        FFMpeg::fromDisk('local')->open($this->video->path)
        ->exportForHLS()
        ->onProgress(function($percentage) {
            if($percentage - $this->lastPerc >= 10 || $percentage == 100) {
                $this->video->update([
                    'percentage' => $percentage
                ]);
            }
        })
        ->addFormat($low)
        ->addFormat($medium)
        ->addFormat($high)
        ->addFormat($HD)
        ->save("public/streamable_videos/{$this->video->id}/{$this->video->id}.m3u8");
    }
}
