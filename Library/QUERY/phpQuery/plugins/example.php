<?php
/**
 * Example of QUERY plugin.
 *
 * Load it like this:
 * QUERY::plugin('example')
 * QUERY::plugin('example', 'example.php')
 * pq('ul')->plugin('example')
 * pq('ul')->plugin('example', 'example.php')
 *
 * Plugin classes are never intialized, just method calls are forwarded
 * in static way from QUERY.
 *
 * Have fun writing plugins :)
 */

/**
 * QUERY plugin class extending QUERY object.
 * Methods from this class are callable on every QUERY object.
 *
 * Class name prefix 'phpQueryObjectPlugin_' must be preserved.
 */
abstract class phpQueryObjectPlugin_example {
	/**
	 * Limit binded methods.
	 *
	 * null means all public.
	 * array means only specified ones.
	 *
	 * @var array|null
	 */
	public static $phpQueryMethods = null;
	/**
	 * Enter description here...
	 *
	 * @param phpQueryObject $self
	 */
	public static function example($self, $arg1) {
		// this method can be called on any QUERY object, like this:
		// pq('div')->example('$arg1 Value')

		// do something
		$self->append('Im just an example !');
		// change stack of result object
		return $self->find('div');
	}
	protected static function helperFunction() {
		// this method WONT be avaible as QUERY method,
		// because it isn't publicly callable
	}
}

/**
 * QUERY plugin class extending QUERY static namespace.
 * Methods from this class are callable as follows:
 * QUERY::$plugins->staticMethod()
 *
 * Class name prefix 'phpQueryPlugin_' must be preserved.
 */
abstract class phpQueryPlugin_example {
	/**
	 * Limit binded methods.
	 *
	 * null means all public.
	 * array means only specified ones.
	 *
	 * @var array|null
	 */
	public static $phpQueryMethods = null;
	public static function staticMethod() {
		// this method can be called within QUERY class namespace, like this:
		// QUERY::$plugins->staticMethod()
	}
}
?>