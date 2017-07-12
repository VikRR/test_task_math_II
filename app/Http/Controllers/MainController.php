<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


class MainController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $client = new Client();

        $res = $client->request('get', 'https://bookmakersrating.ru/news_homepage');

        $body = $res->getBody();

        $crawler = new Crawler();

        $crawler->addHtmlContent($body);

        $nodeTitle = $crawler
            ->filter('#component-1 .post-heading-container  > .post-heading > .h2')
            ->each(function (Crawler $node, $i) {
                return $node->text();
            });

        $nodeDescription = $crawler
            ->filter('#component-1 .post-excerpt > p')
            ->each(function (Crawler $node, $i) {
                return $node->text();
            });

        $nodeImage = $crawler
            ->filter('#component-1 .image')
            ->each(function (Crawler $node, $i) {
                return $node->attr('style');
            });

        $str = implode(';', $nodeImage);

        preg_match_all('~(?<=url\().*?(?=\))~', $str, $matches);

        $news = [];
        $count = count($nodeTitle);
        for ($i = 0; $i < $count; $i++) {
            $str = trim(mb_substr($nodeDescription[$i], 0, 400),'?,.!');
            $str .= "&#160;&#8230;";
            $news[$i]['title'] = $nodeTitle[$i];
            $news[$i]['description'] = $str;
            $news[$i]['image'] = $matches[0][$i];
        }

        shuffle($news);

        $data = array_slice($news, 0,6);

        return view('index', compact('data'));
    }


}