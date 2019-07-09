<?php

class Loginchecker
{
    private $CI;

    function __construct()
    {
        $this->CI = & get_instance();
        
        $this->CI->load->helper('url');
        $this->CI->load->library('Acl');
        
        if (! isset($this->CI->session)) { // Check if session lib is loaded or not
            $this->CI->load->library('session'); // If not loaded, then load it here
        }
    }

    function loginCheck()
    {
        $controller = $this->CI->uri->rsegment(1);
        $action     = $this->CI->uri->rsegment(2);
        
        if ($this->CI->session->userdata('user_id')) {
            // Check for ACL
            if (! $this->CI->acl->hasAccess()) {
                if ($controller != 'dashboard' && in_array($controller . '/' . $action, $this->CI->acl->getGuestPages())) {
                    return redirect('/Home');
                }
            }
        } else {
            if ($controller != 'login' && ! in_array($controller . '/' . $action, $this->CI->acl->getGuestPages())) {
               //return redirect('/login');
            }
        }
    }
}

?>
