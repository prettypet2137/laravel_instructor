<?php

namespace Modules\User\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Events\Entities\Guest;


class BirthdayEmailCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'guests:birthday-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a birthday email to guests.';

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
        $now = date("Y-m-d H:i:s");
        // Guest::whereDate("birthday", $now)

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
