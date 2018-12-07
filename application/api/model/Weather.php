<?php 
namespace app\api\model;

use think\Model;
use think\Db;

class Weather extends Model
{
    public function getNews($weather_code = 101010100)
    {
        $res = Db::name('ins_county')->where('weather_code', $weather_code)->value('weather_info');
        return $res;
    }

    public function getNewsList()
    {
        $res = Db::name('ins_county')->select();
        return $res;
    }
}