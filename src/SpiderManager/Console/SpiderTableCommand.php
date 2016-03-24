<?php

namespace SpiderManager\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Composer;
use Illuminate\Filesystem\Filesystem;

class SpiderTableCommand extends Command
{
    /**
     * the command name
     *
     * @var string
     */
    protected $name = 'spider:table';

    /**
     * the command description
     *
     * @var string
     */
    protected $description = 'Create a migration for the spider database table';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Illuminate\Foundation\Composer
     */
    protected $composer;

    /**
     * Create a new spider table command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     * @param  \Illuminate\Foundation\Composer $composer
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * handle command
     *
     * @return void
     *               -- Auth by Daozi. on 2016.3.17
     */
    public function  fire()
    {
        $fullPath = $this->createBaseMigration();

        $this->files->put($fullPath, $this->files->get(__DIR__.'/stubs/database.stub'));

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * create migrate file
     *
     * @return string
     *             -- Auth by Daozi. on 2016.3.17
     */
    protected function createBaseMigration()
    {
        $name = 'create_spider_table';

        $path = $this->laravel->databasePath().'/migrations';

        return $this->laravel['migration.creator']->create($name, $path);
    }
}
