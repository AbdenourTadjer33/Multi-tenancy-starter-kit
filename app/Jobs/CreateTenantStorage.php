<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;

class CreateTenantStorage implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /** @var TenantWithDatabase|Model */
    protected $tenant;

    public function __construct(TenantWithDatabase $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->tenant->run(function () {
            $storage_path = storage_path();
            $source_path = base_path('stubs/base');
            
            Log::info('storage path ' . $storage_path);
            Log::info('source path ' . $source_path);
            
            mkdir($storage_path, 0777, true);

            (new Filesystem)->copyDirectory(base_path('stubs/base'), $storage_path);
        });
    }
}
