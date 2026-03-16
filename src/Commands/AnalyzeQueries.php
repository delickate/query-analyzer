<?php

namespace Delickate\QueryAnalyzer\Commands;

use Illuminate\Console\Command;
use DB;

class AnalyzeQueries extends Command
{
    protected $signature = 'query-analyzer:run';
    protected $description = 'Analyze queries in the application';

    public function handle()
    {
        $this->info('Query Analyzer Started');

        DB::listen(function ($query) {
            if ($query->time > config('query-analyzer.slow_query_threshold_ms')) {
                $this->warn("Slow Query ({$query->time}ms): {$query->sql}");
            }
        });

        $this->info('Listening for queries...');
    }
}