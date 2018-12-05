<?php

class Rates_controller_test extends TestCase
{
    
    public function test_list(){
        $output = $this->request('GET', ['Rates_controller','list']);
        $expected = '<h2>Gestion des Tarifs</h2>';
        $this->assertContains($expected,$output);		
	}

    public function test_edit(){
        $output = $this->request('GET', ['Rates_controller','edit',1]);
        $expected = '<label for="inputname">Nom</label>';
        $this->assertContains($expected,$output);		
	}

}

?>
