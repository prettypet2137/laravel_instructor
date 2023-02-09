<?php

namespace Modules\Saas\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Saas\Notifications\SubscriptionExpired;
use Modules\User\Entities\User;
use Modules\Jobs\Entities\Job;

class CheckExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rb:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification about expired subscriptions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNotNull('package_ends_at')
            ->where('package_ends_at', '<=', now())
            ->get();

        foreach ($users as $user) {
            $user->notify((new SubscriptionExpired())->onQueue('mail'));
            $user->package_ends_at = null;
            $user->save();

            // Check set null company feature and job featured.
            $company = $user->company()->first();
            if ($company) {

                # Reset company featured
                $company->is_featured = false;
                $company->save();

                # Reset featured all jobs
                Job::where('company_id', $company->id)
                ->where('is_featured', 1)
                ->update([
                    'is_featured' => 0
                ]);
            }
           
                        
            $this->info('Subscription expired for: ' . $user->name);
        }

    }
}
