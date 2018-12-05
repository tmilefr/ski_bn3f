<?php

class Input_model_test extends TestCase
{
    protected $json_path = APPPATH.'tests/mocks/';

    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Input_model');
        $this->CI->load->library('bootstrap_tools');
        $this->obj = $this->CI->Input_model;
    }

    public function test_get_inputs()
    {
        $this->obj->_set('filter', ['user'=>43]);
        $inputs = $this->obj->get_inputs(8,2018);
        $json = file_get_contents($this->json_path.'input_result.json');
		$json = json_decode($json);
        foreach($inputs AS $key=>$expected)
        {
            $this->assertEquals($expected, $json[$key] );
        }
    }

}

?>
