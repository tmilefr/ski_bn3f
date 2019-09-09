<?php

class Loginchecker
{
    private $CI;

    function __construct()
    {
        $this->CI = & get_instance();
        
        $this->CI->load->helper('url');
        $this->CI->load->library('Acl');
         
        if (! isset($this->CI->session)) { 
            $this->CI->load->library('session'); 
        }    
    }

    function loginCheck()
    {
        $controller = $this->CI->uri->rsegment(1);
        $action     = $this->CI->uri->rsegment(2);
        
        
        if ($this->CI->session->userdata('usercheck')) {
            // Check for ACL
            if (! $this->CI->acl->hasAccess()) {
                if ($controller != 'dashboard' && in_array($controller . '/' . $action, $this->CI->acl->getGuestPages())) {
                    return redirect('/Home');
                }
            }
        } else {
            if ($controller != 'login' && ! in_array($controller . '/' . $action, $this->CI->acl->getGuestPages())) {
               return redirect('/Login');
            }
        }
    }
}

?>
