<?php
namespace app\api\controller;

use think\Controller;

class Weather extends Controller
{
    public function read()
    {
        $county_name = input('county_name');
        $model = model('Weather');
        $data = $model->getNews($county_name);
        if ($data) {
            $city = '北京';
        } else {
            $city = 404;
        }
        $data = [
            'city' => $county_name,
            'data' => $data
        ];
        return json($data);
    }
}