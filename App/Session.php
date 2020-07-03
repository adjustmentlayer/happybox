<?php

namespace App;

class Session
{
    /**
     * Add value to session
     * 
     * @param string $name
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public static function add($name, $value)
    {
        if($name != '' 
            && $value != '' 
            && !empty($name) 
            && !empty($value))
        {
            return $_SESSION[$name] = $value;
        }else{
            throw new \Exception('Name and value are required');
        }
    }
    /**
     * Get value from session
     * 
     * @param string $name
     * @return mixed
     */
    public static function get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * Check if session exists
     * 
     * @param string $name
     * @return bool
     * @throws \Exception
     */
    public static function has($name)
    {
        if($name != '' && !empty($name) )
        {
            return (isset($_SESSION[$name])) ? true : false;
        }
        throw new \Exception('name is required');
    }

    /**
     * Remove session
     * 
     * @param string $name
     *  */ 
    public static function remove($name)
    {
        if(self::has($name)){
            unset($_SESSION[$name]);
        }
    }
}