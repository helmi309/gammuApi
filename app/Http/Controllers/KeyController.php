<?php

/*
 * This file is part of Gammu Web API
 *
 * (c) Kristian Drucker <kristian@rolmi.sk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers;

use App\Key;
use Illuminate\Http\Request;


class KeyController extends Controller
{
    public function create()
    {
        $key = $this->generateKey(32);
        $keys = Key::where('key', $key)->first();
        if ($keys) {
            $key = $this->generateKey(32);
        }
        Key::create(['key' => $key]);

        return $key;
    }

    public function revoke(Request $request)
    {
        if (!$request->input('key')) {
            return response('You need to provide a key', 400);
        }
        $key = Key::where('key', $request->input('key'))->first();
        if (!$key) {
            return response('You need to provide an authentic key', 401);
        }
        Key::destroy($key->id);

        return response('Successfully revoked key', 200);
    }

    private function generateKey($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
