<?php

class Family_controller_test extends TestCase
{

    public function test_view()
    {
        $output = $this->request('GET', ['Family_controller','view',6]);
        $expected = 'LARESSER';
        $this->assertContains($expected,$output);
    }
    
    public function test_list(){
        $output = $this->request('GET', ['Family_controller','list']);
        $expected = '<h2>Gestion des Familles</h2>';
        $this->assertContains($expected,$output);		
	}

    public function test_edit(){
        $output = $this->request('GET', ['Family_controller','edit',6]);
        $expected = '<label for="inputname">Nom</label>';
        $this->assertContains($expected,$output);		
	}

}

?>
