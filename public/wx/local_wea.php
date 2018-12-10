<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx4b38fe17681954f5", "d2263302ef9bf61409579339fb8c507f");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
<!--    <link rel="stylesheet" href="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.css">-->
<!--    <script src="https://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>-->
<!--    <script src="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>-->
    <link rel="stylesheet" href="http://res.wx.qq.com/open/libs/weui/0.4.3/weui.min.css"/>
    <title></title>
</head>
<body ontouchstart>
<!--    <div data-role="page" id="pageone">-->
<!--        <div data-role="header" data-position='fixed'>-->
<!--            <h1>欢迎来到柳俊志的天气预报</h1>-->
<!--        </div>-->
<!---->
<!--        <div data-role="main" class="ui-content" >-->
<!--            <p>点击链接查看本地天气</p>-->
<!--            <a href="#pagetwo" data-transition="fade" >本地天气</a>-->
<!--        </div>-->
<!---->
<!--        <div data-role="footer" data-position='fixed'>-->
<!--            <h1>2018年11月25日 星期日</h1>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div data-role="page" data-dialog="true" id="pagetwo">-->
<!--        <div data-role="header">-->
<!--            <h1>今日天气</h1>-->
<!--        </div>-->
<!---->
<!--        <div data-role="main" class="ui-content">-->
<!--            <p>北京市大兴区</p>-->
<!--            <p>当前温度:<b>1℃</b></p>-->
<!--            <p>晴  <b>-3℃</b>～<b>10℃</b></p>-->
<!--            <p>中度污染 <b>182</b>           |                  未来两小时无雨</p>-->
<!--            <p>明天：晴 重度污染 -2℃～10℃</p>-->
<!--            <p>后天：晴 中度污染 -3℃～8℃</p>-->
<!---->
<!--        </div>-->
<!---->
<!--        <div data-role="footer">-->
<!--            <h1>2018年11月25日 星期日</h1>-->
<!--        </div>-->
<!--    </div>-->
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    /*
     * 注意：
     * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
     * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
     * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
     *
     * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
     * 邮箱地址：weixin-open@qq.com
     * 邮件主题：【微信JS-SDK反馈】具体问题
     * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
     */
    var latitude = 0.0;
    var longitude = 0.0;
    wx.config({
        debug: true,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            'getLocation'
            // 所有要调用的 API 都要加到这个列表中
        ]
    });

    wx.ready(function () {
        // 在这里调用 API
        wx.getLocation({
            type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
                alert("latitude:" + latitude + "longitude:" + longitude);

                var request = new XMLHttpRequest();
                var postStr = String(latitude) + "," + String(longitude);
                var data = "location=" + postStr;

                request.onreadystatechange = function() {
                    if (request.readyState == 4) {
                        if (request.status == 200) {
                            var response = request.responseText;
                            var div = document.createElement('div');
                            var p = document.createElement('p');
                            p.innerHTML = response;
                            div.appendChild(p);
                            document.body.appendChild(div);
                        } else {
                        }
                    } else {
                    }
                }
                request.open('POST', "weather_info.php", true);
                request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
                request.send(data);
            }
        });
    });
    function openLocation() {
        wx.ready(function () {
            wx.openLocation({
                latitude: latitude, // 纬度，浮点数，范围为90 ~ -90
                longitude: longitude, // 经度，浮点数，范围为180 ~ -180。
                name: '', // 位置名
                address: '', // 地址详情说明
                scale: 15, // 地图缩放级别,整形值,范围从1~28。默认为最大
                infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
            });
        });
    }
    function scanQRCode() {
        wx.ready(function () {
            wx.scanQRCode({
                needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                }
            });
        });
    }



</script>
</html>