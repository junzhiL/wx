<?php 
namespace app\api\model;

use think\Model;
use think\Db;

class City extends Model
{
    public function getNews($county_name = 北京)
    {
        $res = Db::name('ins_county')->where('county_name', $county_name)->value('weather_code');
        return $res;
    }

    public function getNewsList()
    {
        $res = Db::name('ins_county')->select();
        return $res;
    }
}