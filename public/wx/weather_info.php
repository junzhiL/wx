<?php
     header("Content-type:text/plain; charset=utf-8");
    
    $location= $_POST['location'];
   
    $url_get = "http://api.map.baidu.com/geocoder?location=".$location."&output=json&key=fjDkD13i9PWIGOfmgMTBzdVEbN05LG2G";
    $response = file_get_contents($url_get);
    $data = json_decode($response, true);
    $city = $data['result']['addressComponent']['city'];
    $temp = $city;
	//去掉”市“
	$city = mb_substr($city, 0, mb_strlen($city, 'utf-8') - 1, 'utf-8');
    
    

	$url_get = "http://154.8.139.132/city/".$city;
    $response = file_get_contents($url_get);
    $data = json_decode($response, true);
    $code = $data['code'];

	
	if($code == "200"){
      $citycode = $data['data'];
      
      $url_get = "http://154.8.139.132/weather/".$citycode;
      $response = file_get_contents($url_get);
      $data = json_decode($response, true);
      
      $weather_info = $data['data'];
      echo $temp."<br />".$weather_info;
    }