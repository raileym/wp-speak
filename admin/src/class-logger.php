<?php
namespace WP_Speak;

class Logger extends Basic
{
    protected static $instance;

    private static $logger_mask;
    
    private $random_value;

    protected function __construct()
    {
        $this->_random_value = rand(1,1000);
        self::$logger_mask = 0; //Logmask::LOG_ADMIN;
    }

    public function set_logger_mask($arg_mask)
    {
        self::$logger_mask = $arg_mask;
    }

    public function getmask()
    {
        return self::$logger_mask;
    }

    public function write($arg_mask, $arg_message)
    {
        if (! ($arg_mask & self::$logger_mask) )
        {
            return;
        }
    
        if( WP_DEBUG === true )
        {
            if( is_array( $arg_message ) || is_object( $arg_message ) )
            {
                error_log( print_r( $arg_message, true ) );
            }
            else
            {
                error_log( $arg_message );
            }
        }
    }

    public function log($arg_mask, $arg_message)
    {
        if (is_array($arg_message) || is_object($arg_message))
        {
            $this->write($arg_mask, print_r($arg_message, true));
        }
        else
        {
            $this->write($arg_mask, $arg_message);
        }
    }
}
?>
