<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Pagination extends CI_Pagination {

	function create_links(){

		
		return Parent::create_links();
	}
	
	public function __construct($config = array())
	{
			parent::__construct($config);
	}
	
	
	function create_perpage(){
		// If our item count or per-page total is zero there is no need to continue.
		// Note: DO NOT change the operator to === here!
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
			return '';
		}

		// Calculate the total number of pages
		$num_pages = (int) ceil($this->total_rows / $this->per_page);

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages === 1)
		{
			return '';
		}
		
		
		$per_pages = [10,20,30,40,50];
		
		
		$create_perpage = form_open($this->base_url, []).'<div class="input-group"><span class="input-group-addon"> <uib-pagination total-items="bigTotalItems" ng-model="bigCurrentPage" max-size="maxSize" boundary-links="true" rotate="true" num-pages="numPages" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></uib-pagination></span><span class="input-group-addon"><select id="numbers" class="form-control">';
			  foreach($per_pages AS $nb){
				  $create_perpage .= '<option value="'.$nb.'" '.(($this->per_page == $nb) ? 'selected="selected"':'').'>'.$nb.'</option>';
			  }
		$create_perpage .= '</select></span></div>'.form_close();
		
		return $create_perpage;
	}
	
}

?>
