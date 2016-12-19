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

use App\Jobs\SendSMS;
use App\Key;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sendSms(Request $request)
    {
        if (!$request->input('to')) {
            return response('Please enter a telephone number', 400);
        }
        if (!$request->input('message')) {
            return response('Please enter message', 400);
        }
        if (!$request->input('key')) {
            return response('Please enter auth key', 401);
        }
        if (count($request->input('to')) != 9 || count($request->input('to')) != 10) {
            return response('Please enter valid telephone number', 400);
        }
        $key = Key::where('key', $request->input('key'))->first();
        if (!$key) {
            return response('Please enter valid auth key', 401);
        }
        $this->dispatch(new SendSMS($request->input('to'), $request->input('message'), $request->input('callback'), new Client()));

        return response('Sent message to: '.$request->input('to'), 200);
    }
}
