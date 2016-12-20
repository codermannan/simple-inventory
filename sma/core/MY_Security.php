<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Security extends CI_Security {
 
    function __construct()
    {
        parent::__construct();
    }
 
 
    function csrf_verify()
    {
        if (isset($_SERVER['REDIRECT_QUERY_STRING'])) {
            $path_segments = explode('/', $_SERVER['REDIRECT_QUERY_STRING']);
            $bypass = FALSE;
 
            if ($path_segments[0] == 'home') {
                $bypass = TRUE;
            }
 
            if ( ! $bypass) {
                parent::csrf_verify();
            }
        }
    }
}

/* EOF: MY_Security */