<?php
namespace WP_Speak;

class WP_Option extends Basic
{
    protected static $instance;

	protected function __construct() { }

    public function get_option( $arg_option, $arg_default = false ) {
        assert( null !== $arg_option );
        
        return get_option( $arg_option, $arg_default );
    }
    
    public function update_option( $arg_option, $arg_value, $arg_autoload = null ) {
        assert( null !== $arg_option );
        assert( null !== $arg_value );
        
        return update_option( $arg_option, $arg_value, $arg_autoload );
    }
    
}

?>
