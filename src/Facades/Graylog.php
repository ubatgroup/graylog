<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 14/03/2018
 * Time: 11:54
 */

namespace Ubatgroup\Graylog\Facades;


use Illuminate\Support\Facades\Facade;

class Graylog extends Facade {
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return 'graylog';
	}
}