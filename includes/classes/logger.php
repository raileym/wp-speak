<?php
namespace WP_Speak;

class Logger extends Basic
{
    protected static $_instance;

    private static $_logger_mask;
    
    private $_random_value;

    protected function __construct()
    {
        $this->_random_value = rand(1,1000);
        self::$_logger_mask = 0; //Logmask::LOG_ADMIN;
    }

    public function setmask($arg_mask)
    {
// error_log("*** SET MASK ({$arg_mask}) ERRORLOG ***");
// ob_start();
// debug_print_backtrace();
// error_log(ob_get_clean());
        self::$_logger_mask = $arg_mask;
    }

    public function getmask()
    {
        return self::$_logger_mask;
    }

    public function write($arg_mask, $arg_message)
    {
        if (! ($arg_mask & self::$_logger_mask) )
        {
// error_log("*** WILL NOT PRINT ERRORLOG ***");
            return;
        }
    
// error_log("WILL PRINT ERRORLOG");
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
        //assert('!is_null($arg_mask)');
        //assert('!is_null($arg_message)');
    
//         if ( ! is_string($arg_logmask) ) {
//         
// error_log("Not a string: " . $arg_logmask);
//             $mask = $arg_logmask;
//             
//         } else if ( ! array_key_exists($arg_logmask, Logmask::MASK ) ) {
//         
// error_log("String found but no match: " . $arg_logmask);
//             $mask = Logmask::MASK["log_all"];
//             
//         } else {
//         
// error_log("String found and there is a match: " . $arg_logmask);
//             $mask = Logmask::MASK[$arg_logmask];
// error_log("Mask: " . $mask);
// error_log("Current Mask: " . self::$_logger_mask);
//     
//         }
        
        if (is_array($arg_message) || is_object($arg_message))
        {
            $this->write($arg_mask, "(".basename($_SERVER["SCRIPT_URL"]).") ".print_r($arg_message, true));
        }
        else
        {
            $this->write($arg_mask, "(".basename($_SERVER["SCRIPT_URL"]).") ".$arg_message);
        }
    }
}
?>
