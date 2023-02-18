<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

	protected $middlewareGroups = [
        'web' => [
            //Laravel Middleware Groups & your custom middleware
			\App\Http\Middleware\Localization::class,
        ],

        'api' => [
            // API middleware groups
        ],
    ];
	
}