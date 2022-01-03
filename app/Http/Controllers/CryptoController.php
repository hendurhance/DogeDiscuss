<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class CryptoController extends Controller
{

    private $apiKey;
    private $expiredAt;
    public function __construct()
    {
        $this->middleware('throttle:10,1');
        $this->apiKey = env('NEWS_API_KEY');
    }

    public function doge()
    {
        $url = 'https://api.coinlore.net/api/ticker/?id=2';
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        $doge = json_decode($res->getBody());
        return $doge;
    }

    // get news from newsapi.org
    public function dogeNews()
    {
        // get doge coin related news in english language for today
        $url = 'https://newsapi.org/v2/everything?q=doge&language=en&sortBy=publishedAt&apiKey=' . $this->apiKey;
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        $dogeNews = json_decode($res->getBody());
        // cache the news for a day
        $expiredAt = Carbon::now()->addDay();
        $this->expiredAt = $expiredAt;
        
        // pluck only the required fields into object array with key value pairs and index them by id
        foreach ($dogeNews->articles as $key => $value) {
            $dogeNews->articles[$key] = [
                'id' => $key,
                'title' => $value->title,
                'description' => $value->description,
                'url' => $value->url,
                'urlToImage' => $value->urlToImage,
                'publishedAt' => $value->publishedAt
            ];
        }
        // if there are no articles, return empty array
        if (count($dogeNews->articles) == 0) {
            return response()->json([
                'articles' => [],
                'status' => 'success',
                'message' => 'No articles found',
                'expiredAt' => $this->expiredAt
            ], Response::HTTP_OK);
        }

        $dogeCollection = [
            'articles' => $dogeNews->articles,
            'status' => 'success',
            'expiredAt' => $this->expiredAt
        ];
        
        // cache the news for a day
        Cache::put('dogeNews', $dogeCollection, $expiredAt);

        // if there is a cached news, return and remember it for a day
        if (Cache::has('dogeNews')) {
            return Cache::get('dogeNews');
        }
        
        return Cache::remember('dogeNews', $expiredAt, function () use ($dogeCollection) {
            return response()->json($dogeCollection, Response::HTTP_OK);
        });
    }
}
