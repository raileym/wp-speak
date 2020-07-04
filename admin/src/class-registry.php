<?php
namespace WP_Speak;

class Registry extends Basic
{
	/**
	 * $instance supports the Singleton creation design.
	 *
	 * @var Registry $instance.
	 */
    protected static $instance;

	/**
	 * $array_registry is a handle to an array of registries.
	 *
	 * @var Array_Registry $array_registry.
	 */
    private static $array_registry;
    

    /**
     * This version of the constructor supports the Singleton
     * creation design.
     */
    protected function __construct()
    {
    }
        
    public function init_table_registry($arg_table)
    {
        $id      = $arg_table->id();
        $tag     = $arg_table->tag();
        $results = $arg_table->fetch_all();

        $row_list = array();
        foreach ($results as $result) {
            $row_list[$result[$id]] = $result;
        }

        self::$array_registry->set($tag, $row_list);
        
        return $this;
        
        
        

        foreach ($results as $key => $value) {
            self::$array_registry->set($key, $value);
        }
        
        self::$logger->log(self::$mask, "-1-----------------------------------");

        return $this;
    }
    
    public function init_registry($arg_page, $arg_name_list)
    {
        $option = get_option($arg_page);
        
        foreach ($arg_name_list as $name) {
            self::$array_registry->set($name, $value = (isset($option[$name])) ? $option[$name] : null);
            false === strpos($name, "password") && self::$logger->log(self::$mask, "Set Registry. {$name} = {$value}");
            false !== strpos($name, "password") && self::$logger->log(self::$mask, "Set Registry. {$name} = ".str_repeat("*", 8));
        }
        
        self::$logger->log(self::$mask, "-2-----------------------------------");
        return $this;
    }
    
    public function init_log_registry($arg_page, $arg_name_list)
    {
        self::$logger->log(self::$mask, __FUNCTION__."({$arg_page})");
        self::$logger->log(self::$mask, __FUNCTION__ . print_r($arg_name_list, true));

        $option = get_option($arg_page);

        self::$logger->log(self::$mask, "MASK OPTIONS on init: " . print_r($option, true));

// error_log("********************");
// error_log("********************");
// error_log( print_r($arg_name_list, true) );
// error_log( print_r($option, true) );
// error_log("********************");
// error_log("********************");

        foreach ($arg_name_list as $name) {
            if (isset($option[$name])  && 0 !== $option[$name]) {
                self::$array_registry->set($name, $value = $option[$name]);
                self::$logger->setmask(self::$logger->getmask() | Logmask::MASK[$name]);
                self::$logger->log(self::$mask, "Set Registry. {$name} = ON");
            } else {
                self::$array_registry->set($name, $value = null);
                self::$logger->setmask(self::$logger->getmask() & ~Logmask::MASK[$name]);
                self::$logger->log(self::$mask, "Set Registry. {$name} = OFF");
            }
        }
        
        self::$logger->log(self::$mask, "-3-----------------------------------");
        return $this;
    }
    
    public function update_registry($arg_output, $arg_name_list)
    {
        self::$logger->log(self::$mask, __FUNCTION__ . print_r($arg_output, true));
        self::$logger->log(self::$mask, __FUNCTION__ . print_r($arg_name_list, true));

        foreach ($arg_name_list as $name) {
            self::$array_registry->set($name, $value = (isset($arg_output[$name])) ? $arg_output[$name] : null);
            false === strpos($name, "password") && self::$logger->log(self::$mask, "Update Registry. {$name} = {$value}");
            false !== strpos($name, "password") && self::$logger->log(self::$mask, "Update Registry. {$name} = ".str_repeat("*", 8));
        }

        self::$logger->log(self::$mask, "-4-----------------------------------");
        return $arg_output;
    }
            
    public function update_log_registry($arg_output, $arg_name_list)
    {
        self::$logger->log(self::$mask, __FUNCTION__ . " " . print_r($arg_output, true));
        self::$logger->log(self::$mask, __FUNCTION__ . " " . print_r($arg_name_list, true));

        self::$logger->log(self::$mask, "MASK OPTIONS on update: " . " " . print_r($arg_output, true));

// error_log("Working each name");
// error_log( print_r($arg_name_list, true) );
// error_log("Comparison to ...");
// error_log( print_r($arg_output, true) );

        foreach ($arg_name_list as $name) {
            if (isset($arg_output[$name])) {
                self::$array_registry->set($name, $value = $arg_output[$name]);
                self::$logger->setmask(self::$logger->getmask() | Logmask::MASK[$name]);
                self::$logger->log(self::$mask, "Update Registry. {$name} = ON");
            } else {
// error_log("Turn mask off for {$name}");
// error_log("Current mask is " . self::$logger->getmask());
                self::$array_registry->set($name, $value = "OFF");
                self::$logger->log(self::$mask, "Update Registry. {$name} = OFF");
                self::$logger->setmask(self::$logger->getmask() & ~Logmask::MASK[$name]);
// error_log("Current mask is " . self::$logger->getmask());
            }
        }

        self::$logger->log(self::$mask, "-5-----------------------------------");
        return $arg_output;
    }


	/**
	 * The function set_array_registry sets the instance handle for the array_registry.
	 *
	 * @param Logger $arg_array_registry is a handle to an array_registry instance.
	 */
	public function set_array_registry( Array_Registry $arg_array_registry ) {
		self::$array_registry = $arg_array_registry;
		return $this;
	}

}

