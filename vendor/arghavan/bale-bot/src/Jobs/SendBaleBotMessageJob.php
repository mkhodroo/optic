<?php

namespace BaleBot\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use BaleBot\Controllers\TelegramController;
use Illuminate\Support\Facades\Log;

class SendBaleBotMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $params;
    protected $method;

    public function __construct($method,array $params)
    {
        $this->params = $params;
        $this->method = $method;
    }

    public function handle()
    {
        Log::info($this->method);
        $bale = new TelegramController();
        $method = $this->method;
        $bale->$method($this->params);
    }
}

