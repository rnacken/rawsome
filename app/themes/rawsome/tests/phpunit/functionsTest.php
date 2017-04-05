<?php

class functionsTest extends PHPUnit_Framework_TestCase {

    public function testNewArticle(){
        $test = 'some test'; 
        $this->assertEquals('some test', $test);
    }

}
