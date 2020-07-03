<?php
namespace WP_Speak;

abstract class Basic
{
	protected static $mask;
	protected static $registry;
	protected static $logger;
	//protected static $instance;

	public static function get_instance()
	{


if ( is_null(static::$instance) ) {
    $class = get_called_class();
//    error_log("Will create class: {$class}");
    static::$instance = new $class();
}

return static::$instance;

        // See https://stackoverflow.com/questions/30388424/how-to-instantiate-a-child-singleton-of-an-abstract-class
// 		$class = get_called_class();
// 		is_null(self::$instance) && self::$instance = new $class();
// 		return self::$instance;


// 		is_null(self::$instance) && self::$instance = new self;
// 		return self::$instance;
	} 
    
    public function set_mask($arg_mask)
	{
		//assert( '!is_null($arg_mask)' );
		self::$mask = $arg_mask;
		return $this;
	}
	
	public function set_logger( $arg_logger)
	{
		//assert( '!is_null($arg_registry)' );
		self::$logger = $arg_logger;
		return $this;
	}
		
	public function set_registry( Registry $arg_registry)
	{
		//assert( '!is_null($arg_registry)' );
		self::$registry = $arg_registry;
		return $this;
	}
		
}

?>
