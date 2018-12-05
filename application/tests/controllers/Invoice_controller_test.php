<?php

class Invoice_controller_test extends TestCase
{

    public function test_view()
    {
        $output = $this->request('GET', ['Invoice_controller','view',6]);
        $expected = 'Facturation Minutes SKI BN3F';
        $this->assertContains($expected,$output);
    }


    public function test_list()
    {
        $output = $this->request('GET', ['Invoice_controller','list']);
        $expected = '<h2>Gestion des factures</h2>';
        $this->assertContains($expected,$output);		
	}

	public function test_recap()
	{
        $output = $this->request('GET', ['Invoice_controller','recap']);
        $expected = '<h2>Gestion des factures</h2>';
        $this->assertContains($expected,$output);	
        
        $output = $this->request('GET', ['Invoice_controller','recap','10_9','2018']);
        $expected = 'liste des factures';
        $this->assertContains($expected,$output);        
	
	}



}

?>
