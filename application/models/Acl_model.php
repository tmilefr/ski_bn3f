<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acl_model extends CI_Model {

	/**
	 * @brief Get current user by session info
	 * @param   int $userId
	 * @return  array
	 */
	public function getUserRoleId($userId = 0)
	{
	    $query = $this->db->select("u.role_id as role_id")
			->from('users u')
			->where("u.id", $userId)
			->get();
        
		// User was found
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
		    	
			return $row['role_id'];
		}

		// No role
		return 0;
	}

	/**
	 * @brief Get permissions from database for  particular role
	 *
	 * @param   int $roleId
	 * @return  array
	 */
	public function getRolePermissions($roleId = 0)
	{
	    $query = $this->db->select([
    	        "p.action as action",
    	        "r.controller as controller"
            ])
			->from('permissions p')
			->join('resources r', "p.resource_id = r.id")
			->join('role_permissions rp', "rp.permission_id = p.id")
			->where("rp.role_id", $roleId)
			->get();

		$permissions = array();

		// Add to the list of permissions
		foreach ($query->result_array() as $row)
		{		    
			$permissions[] = strtolower($row['controller'] . '/' . $row['action']);
		}
		
		return $permissions;
	}

}
