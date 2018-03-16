<?php

namespace Ubatgroup\Graylog\Providers;

use Ubatgroup\Graylog;
use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Illuminate\Support\ServiceProvider;

class GraylogServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->publishes( [
			__DIR__ . '/../config/graylog.php' => config_path( 'graylog.php' )
		], 'config' );
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->mergeConfigFrom( __DIR__ . '/../config/graylog.php', 'graylog' );

		$server   = $this->app['config']->get( 'graylog.server' );
		$port     = $this->app['config']->get( 'graylog.port' );
		$facility = $this->app['config']->get( 'graylog.facility' );
		$hostname = $this->app['config']->get( 'graylog.host' );
		$add_auth_user_auto = $this->app['config']->get( 'graylog.auto_log_auth_user' );

		$this->app->instance( Graylog::class, new Graylog( new Publisher( new UdpTransport( $server, $port ) ), $hostname, $facility, $add_auth_user_auto ) );

		$this->app->alias( Graylog::class, 'graylog' );
	}
}
