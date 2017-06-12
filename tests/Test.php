<?php

use Jetfuel\Signer\Signer;

class Test extends PHPUnit_Framework_TestCase
{
    public function testSignEmpty()
    {
        $id = 'ed5a003e2b9846cb8024851e20aaa9be';
        $secret = '763865ef4f8d4a72856702527151eed5';
        $timestamp = 1497257032;
        $baseUrl = 'https://example.app/api/v1';

        $signature = Signer::sign($id, $secret, $timestamp, $baseUrl);

        $this->assertEquals($signature, 'ORrFgNsgtoP7RO4vwFmGWn5HjDV1LPBje60CYi9UMKY=');
    }

    public function testSignUrl()
    {
        $id = 'ffe877812ab842a1bc30b27751bbd6ac';
        $secret = '381ec44adb8347c68ea0eb4d43212dab';
        $timestamp = 1497257108;
        $baseUrl = 'https://example.app/api/v1/players';

        $signature = Signer::sign($id, $secret, $timestamp, $baseUrl);

        $this->assertEquals($signature, 'i74cpg3LVktf/jAI/N04wwLcyahdAkwL3N/l4yLkAGI=');
    }

    public function testSignDirtyUrl()
    {
        $id = '8a91e76995b442b7860cb37b7284bced';
        $secret = 'c86761be2c644b0db56cc00ab021621a';
        $timestamp = 1497258404;
        $baseUrl = 'https://example.app/api/v1/?sflps=sfs&nhfs=adt sgh';
        $parameters = [
            'zoo'     => 'zo a',
            'bang as' => 'banz',
            'hosd'    => 'wel+df',
            'jii+fk'  => 'osdj',
        ];

        $signature = Signer::sign($id, $secret, $timestamp, $baseUrl, $parameters);

        $this->assertEquals($signature, 'p2UvVUG+xqlxCBEnmdR1C9Z94rE5BgMTJFAL4g/h3+I=');
    }

    public function testSignParams()
    {
        $id = 'ffe877812ab842a1bc30b27751bbd6ac';
        $secret = '381ec44adb8347c68ea0eb4d43212dab';
        $timestamp = 1497256470;
        $baseUrl = 'https://example.app/api/v1/orders';
        $parameters = [
            'id'        => 12,
            'recipient' => 'Grand Canyon',
            'email'     => 'grand@gmail.com',
            'address'   => 'PO Box 129 Grand Canyon, AZ 86023',
        ];

        $signature = Signer::sign($id, $secret, $timestamp, $baseUrl, $parameters);

        $this->assertEquals($signature, 'i9FVroaK4yF1uOrQw09BCRFWy9RrPEl6AZus3DInUCI=');
    }

    public function testSignUnicodeParams()
    {
        $id = '8a91e76995b442b7860cb37b7284bced';
        $secret = 'c86761be2c644b0db56cc00ab021621a';
        $timestamp = 1497257726;
        $baseUrl = 'https://example.app/api/v1/articles';
        $parameters = [
            'ja' => 'このページでは、295ある全てのウィキペディアを言語のグループ（語族・語派など）で分類した一覧を掲載しています。',
            'ko' => '각 언어별 위키백과는 해당 언어 부호(ISO 639)를 wikipedia.org 도메인의 서브도메인으로 사용한다.',
            'hi' => 'इस पृष्ट पर आधिकारिक विकिपीडियाओं की पूरी सूची दी गई है',
            'kk' => 'Бағандар бойынша өсу не кему ретімен орналастыруға болады',
            'zh' => '本頁主要刊登維基百科多種語言的排序的列表，最近一次更新於2015年5月18日',
            'pt' => 'O formato das datas não cumpre as normas da Convenção de nomenclatura da Wikipédia',
        ];

        $signature = Signer::sign($id, $secret, $timestamp, $baseUrl, $parameters);

        $this->assertEquals($signature, '5LVp+M4TGuq64OAKY+eYmPqHSCyg4yneN145X+wpw5o=');
    }

    public function testCompareTrue()
    {
        $id = 'a963e74344da4bffb8c105187262a4c5';
        $secret = '453342fd1ce34f78a0e1872515ebddf1';
        $timestamp = 1497258038;
        $baseUrl = 'https://example.app/api/v1';
        $parameters = [
            'foo' => 'bar',
        ];

        $isCompare = Signer::compare('gR0spTfC2zvofvIovDeRBzDML/Z+148gFIEylYy87FA=', $id, $secret, $timestamp, $baseUrl, $parameters);

        $this->assertTrue($isCompare);
    }

    public function testCompareFalse()
    {
        $id = 'a963e74344da4bffb8c105187262a4c5';
        $secret = '453342fd1ce34f78a0e1872515ebddf1';
        $timestamp = 1497258127;
        $baseUrl = 'https://example.app/api/v1';

        $isCompare = Signer::compare('OxKDCvGSA6yXBF8J6Sv4XRCE8/9y8jMkq56O4SByNtY=', $id, $secret, $timestamp, $baseUrl);

        $this->assertFalse($isCompare);
    }
}
