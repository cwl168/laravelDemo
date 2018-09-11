<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class QueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  QueryExecuted  $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        $sql = str_replace("?", "'%s'", $event->sql);
        $log = '[' . date('Y-m-d H:i:s') . '] ' . vsprintf($sql, $event->bindings) . "\r\n";
        Log::info($log);
        $filepath = storage_path('logs//' . date('Y-m-d') . '.log');
        file_put_contents($filepath, $log, FILE_APPEND);
    }
}
