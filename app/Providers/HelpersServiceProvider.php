<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class HelpersServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		require_once app_path().'/Helpers/Helpers.php';
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		Log::setTimezone(new \DateTimeZone('Asia/Jakarta')); # Set timezone for logging
	}
}
