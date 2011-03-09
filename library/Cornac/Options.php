<?php
/*
   +----------------------------------------------------------------------+
   | Cornac, PHP code inventory                                           |
   +----------------------------------------------------------------------+
   | Copyright (c) 2010 - 2011                                            |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Author: Damien Seguy <damien.seguy@gmail.com>                        |
   +----------------------------------------------------------------------+
 */


class Cornac_Options {
    private $INI = array('cornac' => array());
    
    // @todo those will soon disappear
    private $options = array();
    private $cornac = array();

    function __get($name) {
        return $this->INI[$name];
    }

    function __set($name, $value) {
        if (in_array($name, array('options'))) {
            $this->$name = $value; 
        } elseif (is_array($value)) {
        // @note last array overwrite previous values
            if (!isset($this->INI[$name])) { $this->INI[$name] = array(); }
            $this->INI[$name] = array_merge($this->INI[$name], $value);
        } else {
            $this->INI[$name] = $value;
        }
    }

    function __isset($name) {
        return isset($this->INI[$name]);
    }

    function setConfig($options) {
        $this->options = $options;
    }

    function get_arg_value(&$args, $option=null, $default_value=null) {
        if ($id = array_search($option, $args)) {
            if (!isset($args[$id + 1])) { 
                unset($args[$id]);
                return $default_value;
            }
            $return = $args[$id + 1];
            unset($args[$id]);
            unset($args[$id + 1]);
        } else {
            $return = $default_value;
        }
        return $return; 
    }
    
    /**
      * Read options with no value
      */
    function get_arg(&$args, $option) {
        if ($id = array_search($option, $args)) {
            unset($args[$id]);
            $return = true;
        } else {
            $return = false;
        }
        return $return; 
    }
    
    function help() {
    // @todo add default values in help display
        $options = $this->INI['help_options'];
        
        $r = 'Usage : '.$_SERVER['SCRIPT_NAME'];
        
        $list = '';
        foreach($this->options as $name => $option) {
            $list .= "-{$option['option']} : {$option['help']}\n";
            if ($option['compulsory']) {
                $r .= " -{$option['option']} <$name>";
            }
        }
        $r .= "\n\n$list\n";
        
        return $r;
    }
    
    function init() {
    //    if (empty($this->$options)) { return false; }
        $this->INI = array('help_options' => $this->options);
    
        global $argv;
        $args = $argv;    
        
        if ($this->get_arg($args, '-?')) { 
            print $this->help(); 
            // @todo $this doesn't belong here
            die(); 
        }
        
        foreach($this->options as $name => $option) {
            if (array_key_exists('get_arg_value', $option)) {
                $this->INI[$name] = $this->get_arg_value($args, '-'.$option['option'], $option['get_arg_value']);
                if (empty($this->INI[$name])) {
                    $this->INI[$name] = $option['get_arg_value'];
                }
            } else {
                $this->INI[$name] = $this->get_arg($args, '-'.$option['option']);
            }
    
            
            if ($option['compulsory'] && empty($this->INI[$name])) {
                print("Option -{$option['option']} <$name> is compulsory. \n");
                // @todo $this doesn't belong here, does it?
                print $this->help($options);
                die();
            }
        }
        
        if (!empty($this->INI['ini'])) {
            $path = dirname(dirname(dirname(__FILE__))).'/ini/';
            if (file_exists($path.$this->INI['ini'])) {
                $ini = parse_ini_file($path.$this->INI['ini'], true);
                $ini['cornac']['ini'] = substr($this->INI['ini'], 0, -4); // @note minus .ini
            } elseif (file_exists($path.$this->INI['ini'].".ini")) {
                $ini = parse_ini_file($path.$this->INI['ini'].".ini", true);
                $ini['cornac']['ini'] = $this->INI['ini']; // @note good name
            } else {
                $ini = parse_ini_file($path.'cornac.ini', true);
                $ini['cornac']['ini'] = 'cornac'; // @note default value. Probably wrong.
            }
        } else {
        // @todo this is probably wrong
            $ini = array();
        }
    
        $this->INI = array_merge($this->INI, $ini);
        unset($ini);
        return true;
    }
}

?>