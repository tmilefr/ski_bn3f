<?php
class Render_object_test extends TestCase
{

  public function setUp()
  {
      $this->resetInstance();
      $this->CI->load->library('Render_object');
   }

	public function test_Render_object_reset()
  {

    $this->CI->render_object->_set('test', 'test_affected_var');
    $this->CI->render_object->_reset_value('test');
    $array = $this->CI->render_object->_get('_reset');

		$this->assertEquals( $array['test'], true);
  }
}
?>
