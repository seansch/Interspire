<?php namespace Seansch\Interspire;

use Illuminate\Support\ServiceProvider;

class InterspireServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array('interspire');
    }

}
