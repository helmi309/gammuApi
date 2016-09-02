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
        $key = exec('php ' . base_path('artisan') . ' key:create');
        $this->assertEquals(32, strlen($key));

        $revoke = exec('php ' . base_path('artisan') . ' key:revoke ' . $key);
        $this->assertEquals('Successfully revoked key ' . $key, $revoke);
    }
}
