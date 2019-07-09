<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Acl
{
    protected $CI;

    protected $userId = NULL;

    protected $userRoleId = NULL;

    protected $guestPages = [
        'login/index',
        'login/check'
    ];

    protected $_config = [
        'acl_table_users' => 'users',
        'acl_users_fields' => [
            'id' => 'id',
            'role_id' => 'role_id'
        ],
        'acl_table_resources' => 'resources',
        'acl_resources_fields' => [
            'id' => 'id',
            'controller' => 'controller'
        ],
        'acl_table_permissions' => 'permissions',
        'acl_permissions_fields' => [
            'id' => 'id',
            'resource_id' => 'resource_id',
            'action' => 'action'
        ],
        'acl_table_role_permissions' => 'role_permissions',
        'acl_role_permissions_fields' => [
            'id' => 'id',
            'role_id' => 'role_id',
            'permission_id' => 'permission_id'
        ],
        'acl_user_session_key' => 'user_id'
    ];

    /**
     * Constructor
     *
     * @param array $config            
     */
    public function __construct($config = array())
    {
        $this->CI = &get_instance();
        
        // Load Session library
        $this->CI->load->library('session');
        
        // Load ACL model
        $this->CI->load->model('acl_model');
    }

    public function getAclConfig($key = NULL)
    {
        if ($key) {
            return $this->_config[$key];
        }
        
        return $this->_config;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Check is controller/method has access for role
     *
     * @access public
     * 
     * @return bool
     */
    public function hasAccess()
    {
        if ($this->getUserId()) {
            
            $permissions = $this->CI->acl_model->getRolePermissions($this->getUserRoleId());
            
            if (count($permissions) > 0) {
                $currentPermission = $this->CI->uri->rsegment(1) . '/' . $this->CI->uri->rsegment(2);
                if (in_array($currentPermission, $permissions)) {
                    return TRUE;
                }
            }
        }
        
        return FALSE;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Return the value of user id from the session.
     * Returns 0 if not logged in
     *
     * @access private
     * @return int
     */
    private function getUserId()
    {
        if ($this->userId == NULL) {
            $this->userId = $this->CI->session->userdata($this->_config['acl_user_session_key']);
            
            if ($this->userId === FALSE) {
                $this->userId = NULL;
            }
        }
        
        return $this->userId;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Return user role
     *
     * @return int
     */
    private function getUserRoleId()
    {
        if ($this->userRoleId == NULL) {
            // Set the role
            $this->userRoleId = $this->CI->acl_model->getUserRoleId($this->getUserId());
            
            if (! $this->userRoleId) {
                $this->userRoleId = 0;
            }
        }
        
        return $this->userRoleId;
    }
    
    public function getGuestPages()
    {
        return $this->guestPages;
    }
}
