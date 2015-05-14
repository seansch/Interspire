<?php namespace Seansch\Interspire;

use Illuminate\Support\ServiceProvider;

class InterspireServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->publishes([
            __DIR__ . '/../../config/interspire.php' => config_path('interspire.php'),
        ]);

	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind('interspire', function(){
            return new Interspire;
        });
	}

}
