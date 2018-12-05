<?php

class Parameters_test extends TestCase
{

    public function test_index()
    {
        $output = $this->request('GET', ['Parameters','index']);
        $expected = 'app';
        $this->assertContains($expected,$output);
    }


}

?>
