<?php

namespace Stats4SD\LaravelUi;

use Illuminate\Console\Command;
use InvalidArgumentException;

class UiCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'ui
                    { type : The preset type (backpack, bootstrap, vue, react) }
                    { --option=* : Pass an option to the preset command }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Swap the front-end scaffolding for the application';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function handle()
    {
        if (static::hasMacro($this->argument('type'))) {
            return call_user_func(static::$macros[$this->argument('type')], $this);
        }

        if (! in_array($this->argument('type'), ['backpack', 'bootstrap', 'vue', 'react'])) {
            throw new InvalidArgumentException('Invalid preset.');
        }

        $this->{$this->argument('type')}();

        if ($this->option('auth')) {
            throw new InvalidArgumentException('Please do not use this to scaffold Auth routes. Either use the routes/controllers from Backpack itself or move to Laravel Breeze or Jetstream');
            // $this->call('ui:auth');
        }
    }

    /**
     * Install the "bootstrap" preset.
     *
     * @return void
     */
    protected function bootstrap()
    {
        Presets\Bootstrap::install();

        $this->info('Bootstrap scaffolding installed successfully.');
        $this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
    }

    /**
     * Install the "vue" preset.
     *
     * @return void
     */
    protected function vue()
    {
        Presets\Bootstrap::install();
        Presets\Vue::install();

        $this->info('Vue scaffolding installed successfully.');
        $this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
    }

    /**
     * Install the "react" preset.
     *
     * @return void
     */
    protected function react()
    {
        Presets\Bootstrap::install();
        Presets\React::install();

        $this->info('React scaffolding installed successfully.');
        $this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
    }

    /**
    * Install the "backpack" preset.
    *
    * @return void
    */
    protected function backpack()
    {
        Presets\Bootstrap::install();
        Presets\Vue::install();

        $this->info('Bootstrap + Vue scaffolding installed successfully.');

        Presets\Backpack::install();

        $this->info('Backpack extra dependancies installed successfully.');
        $this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        $this->comment('Also ensure that the following config settings are updated: backpack.base.styles => ["css/app.css"]');
    }
}
