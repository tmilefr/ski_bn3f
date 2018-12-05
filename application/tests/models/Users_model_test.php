<?php

class Users_model_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Users_model');
        $this->obj = $this->CI->Users_model;
    }

    public function test_get_user()
    {
        $user = $this->obj->get_user(1);

        $expected = new StdClass();
        $expected->id = 1;
		$expected->name = 'WEISS';
		$expected->surname = 'Patrick';
		$expected->created = '';
		$expected->updated = '';
		$expected->section =  2;
		$expected->family =  10;
		$expected->oldid =  3;
		$expected->email = '06.15.67.94.19';
		$expected->country = '...';
		$expected->driver = 1;

        $this->assertEquals($expected, $user);
    }

}

?>
