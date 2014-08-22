<?php namespace Andymarrell\Sociauth;

use Illuminate\Support\ServiceProvider;

class SociauthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('andymarrell/sociauth');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['sociauth'] = $this->app->share(function($app){
            return new Sociauth;
        });
        /*
        $this->app->booting(function(){
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Sociauth', 'Andymarrell\Sociauth\Facades\Sociauth');
        });
        */
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
