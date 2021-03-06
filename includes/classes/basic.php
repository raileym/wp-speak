<?php
namespace WP_Speak;

abstract class Basic
{
	protected static $_mask;
	protected static $_registry;
	protected static $_logger;
	//protected static $_instance;

	public static function get_instance()
	{


if ( is_null(static::$_instance) ) {
    $class = get_called_class();
//    error_log("Will create class: {$class}");
    static::$_instance = new $class();
}

return static::$_instance;

        // See https://stackoverflow.com/questions/30388424/how-to-instantiate-a-child-singleton-of-an-abstract-class
// 		$class = get_called_class();
// 		is_null(self::$_instance) && self::$_instance = new $class();
// 		return self::$_instance;


// 		is_null(self::$_instance) && self::$_instance = new self;
// 		return self::$_instance;
	} 
    
    public function set_mask($arg_mask)
	{
		//assert( '!is_null($arg_mask)' );
		self::$_mask = $arg_mask;
		return $this;
	}
	
	public function set_logger( $arg_logger)
	{
		//assert( '!is_null($arg_registry)' );
		self::$_logger = $arg_logger;
		return $this;
	}
		
	public function set_registry( Registry $arg_registry)
	{
		//assert( '!is_null($arg_registry)' );
		self::$_registry = $arg_registry;
		return $this;
	}
		
}

?>
