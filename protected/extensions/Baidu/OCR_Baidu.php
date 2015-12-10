<?php

/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2015/11/30
 * Time: 15:06
 */
class OCR_Baidu
{

    public static function getText($image){

        $ch = curl_init();
//        $url = 'http://apis.baidu.com/apistore/idlocr/ocr';   //免费版
        $url = 'http://apis.baidu.com/idl_baidu/baiduocrpay/idlocrpaid';    //企业收费版
        $header = array(
            'Content-Type:application/x-www-form-urlencoded',
            'apikey: ade13e7e8a7bb0f2f0e81749d5905403',
        );
        $image = base64_encode($image);
        $image = urlencode($image);
        $data = "fromdevice=pc&clientip=10.10.10.0&detecttype=LocateRecognize&languagetype=CHN_ENG&imagetype=1&image=$image";
// 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
// 添加参数
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 执行HTTP请求
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);

        return $res;
    }

}