<?php

namespace App\Jobs\Videos;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConvertForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    public $video;


    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $low = (new \FFMpeg\Format\Video\X264('aac'))->setKiloBitrate(100);

        $mid = (new \FFMpeg\Format\Video\X264('aac'))->setKiloBitrate(250);

        $high = (new \FFMpeg\Format\Video\X264('aac'))->setKiloBitrate(500);

        \FFMpeg::fromDisk('local')
            ->open($this->video->path)
            ->exportForHLS()
            ->onProgress(function($percentage){
                $this->video->update(
                    [
                        'percentage'=>$percentage
                    ]
                );
            })
            ->addFormat($low)
            ->addFormat($mid)
            ->addFormat($high)
            ->save("public/videos/{$this->video->id}/{$this->video->id}.m3u8");
    }
}
