<?php
class Session
{    
    public static function init()
    {        
       // session_cache_expire(__ENV_SESSION_MAX_MINUTES__);
        @session_start();
    }
    
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key)
    {
        if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    }
    
    public static function destroy()
    {
        //unset($_SESSION);
        session_destroy();
    }
    
}