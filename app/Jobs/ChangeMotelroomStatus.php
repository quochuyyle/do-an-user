<?php

namespace App\Jobs;

use App\Motelroom;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ChangeMotelroomStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $motelroom;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Motelroom $motelroom)
    {
        $this->motelroom = $motelroom;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Motelroom $motelroom)
    {
        $motelroom->where('id', $this->motelroom->id)->update(['approve'=> 0]);
    }
}
