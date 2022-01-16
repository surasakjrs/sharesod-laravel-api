<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;

class ReadUrlController extends ApiController
{
    private function getUrlContent($Url)
    {
        $cURL = curl_init(); // Initialize a cURL session
        curl_setopt($cURL, CURLOPT_URL, $Url); // URL to send request to
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1); //return web page data
        $data = curl_exec($cURL); // Perform a cURL session
        curl_close($cURL); // cURL session
        return $data;
    }

    public function get_title($url)
    {
        $str = file_get_contents($url);
        if (strlen($str) > 0) {
            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
            preg_match("/\<title\>(.*)\<\/title\>/i", $str, $title); // ignore case
            return $title[1];
        }
    }

    public function file_get_contents_curl($url)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;

    }

    public function read_url_article(Request $req)
    {
        $url = $req->input('url');
        if (!$url) {
            return $this->respondNoContent();
        }
        $str = $this->file_get_contents_curl($url);
        //$str = file_get_contents($url);
        if (strlen($str) > 0) {
            $str = trim(preg_replace('/\s+/', ' ', $str));
            preg_match("/\<article (.*?)\>(.*)<\/article>/i", $str, $article);

            header('Content-Type: text/html; charset=utf-8');
            echo $article[2];

            //return $this->api_respond($article[2]);
        }
    }

    public function read_url(Request $req)
    {
        $url = $req->input('url');
        if (!$url) {
            return $this->respondNoContent();
        }
        $doc = new DOMDocument();
        @$doc->loadHTMLFile($url);
        $xpath = new DOMXPath($doc);

        $title = $xpath->query('//title')->item(0)->nodeValue;
        $article = $xpath->query('//article')->item(0)->nodeValue;

        $article = str_replace(array("\r\n", "\n"), '', $article);
        $article = str_replace('(adsbygoogle = window.adsbygoogle || []).push({});', '', $article);
        $article = str_replace('Advertisement', '', $article);

        return $this->api_respond(
            ['title' => $title, 'article' => $article]);
        exit;
    }
}
