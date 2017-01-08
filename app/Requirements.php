<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Requirements extends Model
{
    /**
     * 获取需求的sql语句
     */
    public function sqls()
    {
        return $this->hasMany('App\RequirementsSqls','requirement_id');
    }

    /**
     * 获取需求的文件
     */
    public function files()
    {
        return $this->hasMany('App\RequirementsFiles','requirement_id');
    }


    /**
     * 抓取禅道需求数据
     * @param int $serialNumber 需求编号
     * @return array
     */
    public function fetchZenDaoData($serialNumber = 0)
    {
        $client = new Client([
            'base_uri' => 'http://erp.dotfashion.cn',
            'timeout' => 2.0,
            'auth' => ['xuesheng', '123456'],
        ]);
        $response = $client->request('GET', '/www/index.php?m=task&f=view&t=html&id='.$serialNumber);
        $html = $response->getBody()->getContents();

        try {

            $crawler = new Crawler($html);
            $title = $crawler->filter('head>title')->text();

            if (strpos($title, $serialNumber) != false) {
                $name = $crawler->filter('.heading > strong')->text();
                $sponsor = $crawler->filter('#historyItem > li > .item > strong')->first()->text();
                $finishedAt = substr(trim($crawler->filter('.main > fieldset > table')->eq(1)->filter('tr')->eq(2)->filter("td")->text()), 0, 10);
                
                return [
                    'serial_number' => $serialNumber,
                    'name' => $name,
                    'sponsor' => $sponsor,
                    'finished_at' => $finishedAt,
                ];
            }

            return [];

        } catch (\Exception $e) {

            return [];

        }

    }

    

}
