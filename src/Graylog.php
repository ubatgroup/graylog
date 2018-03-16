<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 14/03/2018
 * Time: 09:08
 */

namespace Ubatgroup;


use Gelf\Logger;
use Gelf\Message;
use Gelf\PublisherInterface;

class Graylog extends Logger {

	protected $hostname;
	protected $add_auth_user_auto;

	public function __construct( PublisherInterface $publisher, string $facility, string $hostname, boolean $add_auth_user_auto = true ) {
		$this->publisher          = $publisher;
		$this->facility           = $facility;
		$this->hostname           = $hostname;
		$this->add_auth_user_auto = $add_auth_user_auto;
	}


	protected function initMessage( $level, $message, array $context ) {

		// assert that message is a string, and interpolate placeholders
		$message = (string) $message;
		$context = $this->initContext( $context );
		$message = self::interpolate( $message, $context );

		// create message object
		$messageObj = new Message();
		$messageObj->setHost( $this->hostname );
		$messageObj->setLevel( $level );
		$messageObj->setShortMessage( $message );
		$messageObj->setFacility( $this->facility );

		foreach ( $context as $key => $value ) {
			$messageObj->setAdditional( str_slug( $key ), $value );
		}

		/**
		 * Auto add Auth::user() if connected
		 */
		if ( $this->add_auth_user_auto && \Auth::check() ) {
			$messageObj->setAdditional( "Auth_user", json_encode( \Auth::user() ) );
		}


		return $messageObj;
	}

	/**
	 * Interpolates context values into the message placeholders.
	 *
	 * Reference implementation
	 * @link https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md#12-message
	 *
	 * @param mixed $message
	 * @param array $context
	 *
	 * @return string
	 */
	private static function interpolate( $message, array $context ) {
		// build a replacement array with braces around the context keys
		$replace = array();
		foreach ( $context as $key => $val ) {
			$replace[ '{' . $key . '}' ] = $val;
		}

		// interpolate replacement values into the message and return
		return strtr( $message, $replace );
	}
}