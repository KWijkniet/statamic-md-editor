<?php

namespace Kwijkniet\MdEditor;

use Kwijkniet\MdEditor\Actions\EditMarkdown;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $actions = [
        EditMarkdown::class,
    ];

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    protected $scripts = [
        __DIR__.'/../resources/js/cp.js',
    ];

    public function bootAddon()
    {
        //
    }
}
