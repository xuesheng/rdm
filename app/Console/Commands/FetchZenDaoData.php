<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Mockery\CountValidator\Exception;
use Symfony\Component\DomCrawler\Crawler;

class FetchZenDaoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch-zendao-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'the file is used to fetch the data of zentao!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client([
            'base_uri' => env('ZENDAO_URL'),
            'timeout' => 2.0,
            'auth' => [Auth::user()->zendao_username, Auth::user()->zendao_password],
        ]);

        $response = $client->request('GET', '/www/index.php?m=task&f=view&t=html&id=36331');
        $body = $response->getBody();
        $html = $body->getContents();

        try {

            $crawler = new Crawler($html);
            $title = $crawler->filter('head > title')->text();
            $this->info($title);

            $name = $crawler->filter('.heading > strong')->text();
            $this->info($name);

            $sponsor = $crawler->filter('#historyItem > li > .item > strong')->first()->text();
            $this->info($sponsor);

            $finishDate = $crawler->filter('.main > fieldset > table')->eq(1)->filter('tr')->eq(2)->filter('td')->text();
            $this->info(strtotime($finishDate));


        } catch (\Exception $e) {

            $this->info('需求抓取失败');

        }

    }


}
