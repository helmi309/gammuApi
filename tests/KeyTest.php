<?php

/*
 * This file is part of Gammu Web API
 *
 * (c) Kristian Drucker <kristian@rolmi.sk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


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
            'key' => $key->content(),
        ]);
        $this->assertEquals(200, $revoke->getStatusCode());
    }
}
