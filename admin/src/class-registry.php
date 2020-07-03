<?php
namespace WP_Speak;

// See http://www.devshed.com/c/a/PHP/Registry-Design-Pattern/1/
//
abstract class RegistryAbstract
{

    protected static $instances = array();

    // get Singleton instance of the registry (uses the 'get_called_class()' function available in PHP 5.3)
    public static function get_instance()
    {
        // resolves the called class at run time
        $class = get_called_class();

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class;
        }

        return self::$instances[$class];
    }

    // overriden by some subclasses
    protected function __construct()
    {
    }

    // prevent cloning instance of the registry
    protected function __clone()
    {
    }
}

class ArrayRegistry extends RegistryAbstract
{
    private $data = array();

    public function set($arg_key, $arg_value)
    {
        $this->_data[$arg_key] = $arg_value;
        return $this;
    }

    public function get($arg_key)
    {
        return isset($this->_data[$arg_key]) ? $this->_data[$arg_key] : null;
    }

    public function dump()
    {
        error_log(print_r($this->_data, true));
        return true;
    }
}

class Registry extends Basic
{
    protected static $instance;

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

        ArrayRegistry::get_instance()->set($tag, $row_list);
        
        return $this;
        
        
        

        foreach ($results as $key => $value) {
            ArrayRegistry::get_instance()->set($key, $value);
        }
        
        self::$logger->log(self::$mask, "-1-----------------------------------");

        return $this;
    }
    
    public function init_registry($arg_page, $arg_name_list)
    {
        $option = get_option($arg_page);
        
        foreach ($arg_name_list as $name) {
            ArrayRegistry::get_instance()->set($name, $value = (isset($option[$name])) ? $option[$name] : null);
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
                ArrayRegistry::get_instance()->set($name, $value = $option[$name]);
                self::$logger->setmask(self::$logger->getmask() | Logmask::MASK[$name]);
                self::$logger->log(self::$mask, "Set Registry. {$name} = ON");
            } else {
                ArrayRegistry::get_instance()->set($name, $value = null);
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
            ArrayRegistry::get_instance()->set($name, $value = (isset($arg_output[$name])) ? $arg_output[$name] : null);
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
                ArrayRegistry::get_instance()->set($name, $value = $arg_output[$name]);
                self::$logger->setmask(self::$logger->getmask() | Logmask::MASK[$name]);
                self::$logger->log(self::$mask, "Update Registry. {$name} = ON");
            } else {
// error_log("Turn mask off for {$name}");
// error_log("Current mask is " . self::$logger->getmask());
                ArrayRegistry::get_instance()->set($name, $value = "OFF");
                self::$logger->log(self::$mask, "Update Registry. {$name} = OFF");
                self::$logger->setmask(self::$logger->getmask() & ~Logmask::MASK[$name]);
// error_log("Current mask is " . self::$logger->getmask());
            }
        }

        self::$logger->log(self::$mask, "-5-----------------------------------");
        return $arg_output;
    }
}
