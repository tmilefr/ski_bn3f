<?php

class Users_controller_test extends TestCase
{

    public function test_view()
    {
        $output = $this->request('GET', ['Users_controller','view',6]);
        $expected = 'BURGELIN';
        $this->assertContains($expected,$output);
    }

    public function test_list(){
        $output = $this->request('GET', ['Users_controller','list']);
        $expected = '<h2>Gestion des Membres</h2>';
        $this->assertContains($expected,$output);		
	}

    public function test_edit(){
        $output = $this->request('GET', ['Users_controller','edit',6]);
        $expected = '<label for="inputname">Nom</label>';
        $this->assertContains($expected,$output);		
	}
}

?>
