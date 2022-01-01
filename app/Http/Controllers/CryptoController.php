<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptoController extends Controller
{
    //
    // constrain the class to only allow the following methods
    public function __construct()
    {
        $this->middleware('throttle:10,1');
    }

    public function doge()
    {
        $url = 'https://api.coinlore.net/api/ticker/?id=2';
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        $doge = json_decode($res->getBody());
        return $doge;
    }
}
