<?php

class Inputs_controller_test extends TestCase
{
   
    public function test_list(){
        $output = $this->request('GET', ['Inputs_controller','list']);
        $expected = '<h2>Gestion des Tours</h2>';
        $this->assertContains($expected,$output);		
	}

    public function test_edit(){
        $output = $this->request('GET', ['Inputs_controller','edit',1]);
        $expected = '<label for="inputuser">Membre</label>';
        $this->assertContains($expected,$output);		
	}
	
	/*public function test_add(){
		$output = $this->request(
			'POST',
			'form/index',
			['name' => 'John Smith', 'email' => 'john@example.com']
		);
	}*/


}

?>
