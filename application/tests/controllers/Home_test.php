<?php

class Home_controller_test extends TestCase
{

    public function test_index()
    {
        $output = $this->request('GET', ['Home','index']);
        $expected = 'Top Conso 2018';
        $this->assertContains($expected,$output);
    }


}

?>
