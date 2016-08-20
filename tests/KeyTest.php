<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class KeyTest extends TestCase
{
    /**
     * Key create and delete test.
     *
     * @return void
     */
    public function testKey()
    {
	    $key = $this->call('POST', 'key', []);
	    $this->assertEquals(200, $key->getStatusCode());
	
	    $revoke = $this->call('DELETE', 'key', [
	    	'key' => $key->content()
	    ]);
	    $this->assertEquals(200, $revoke->getStatusCode());
	
    }
}
