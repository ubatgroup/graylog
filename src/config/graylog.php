<?php

return [
	// Address serveur host, use .env GRAYLOG_SERVER to override it
	'server'             => env( 'GRAYLOG_SERVER', '127.0.0.1' ),

	// Port server host, use .env GRAYLOG_PORT to override it
	'port'               => env( 'GRAYLOG_PORT', 12201 ),

	// facility to filter logs (common use application URL), use .env GRAYLOG_FACILITY to override it
	'facility'           => env( 'GRAYLOG_FACILITY', env( 'APP_URL', null ) ),

	// host to filter logs (common use application name), use .env GRAYLOG_HOST to override it
	'host'               => env( 'GRAYLOG_APPNAME', env( 'APP_NAME', null ) ),

	// Add Auth::user data automatically as AdditionalData in every exception handle by the connected user
	'auto_log_auth_user' => true,
];
