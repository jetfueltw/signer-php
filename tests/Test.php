<?php

use Jetfuel\Signer\Signer;

class Test extends PHPUnit_Framework_TestCase
{
    public function testSignOnlyTimestamp()
    {
        $appId = '74e67036f3864044b07fd5d02c5838ea';
        $appSecret = '1e035b2195244ac9a95013e7b1b7be43';
        $timestamp = 1498813737;

        $signature = Signer::signExceptContent($appId, $appSecret, $timestamp);

        $this->assertEquals($signature, 'QF4G4iImbLrePMcKabGTntMBI0LoWEC7p/OyAcrb7zQ=');
    }

    public function testSignFormContentGetEmptyData()
    {
        $appId = 'ed5a003e2b9846cb8024851e20aaa9be';
        $appSecret = '763865ef4f8d4a72856702527151eed5';
        $timestamp = 1498814495;
        $method = 'GET';
        $baseUrl = 'https://example.app/api/v1';

        $signature = Signer::signFormContent($appId, $appSecret, $timestamp, $method, $baseUrl);

        $this->assertEquals($signature, 'eq86qvNCIKaUKoE7CyI/5F7MibUaoWcisHjq+Oi+LmE=');
    }

    public function testSignFormContentPostEmptyData()
    {
        $appId = '381ec44adb8347c68ea0eb4d43212dab';
        $appSecret = '8a91e76995b442b7860cb37b7284bced';
        $timestamp = 1498814596;
        $method = 'POST';
        $baseUrl = 'https://example.app/api/v1';

        $signature = Signer::signFormContent($appId, $appSecret, $timestamp, $method, $baseUrl);

        $this->assertEquals($signature, 'cagT5GURMUb//sqqmaZU9tU6jXy9enaA1WfNVtony10=');
    }

    public function testSignJsonContentGetEmptyData()
    {
        $appId = 'ed5a003e2b9846cb8024851e20aaa9be';
        $appSecret = '763865ef4f8d4a72856702527151eed5';
        $timestamp = 1498815637;
        $method = 'GET';
        $baseUrl = 'https://example.app/api/v1';

        $signature = Signer::signJsonContent($appId, $appSecret, $timestamp, $method, $baseUrl);

        $this->assertEquals($signature, '+TpbKuYnTTf2LDSlFQ/dKaPr786Es9QuRV6Kp4n+QPc=');
    }

    public function testSignJsonContentPostEmptyData()
    {
        $appId = '8a91e76995b442b7860cb37b7284bced';
        $appSecret = '763865ef4f8d4a72856702527151eed5';
        $timestamp = 1498815749;
        $method = 'POST';
        $baseUrl = 'https://example.app/api/v1';

        $signature = Signer::signJsonContent($appId, $appSecret, $timestamp, $method, $baseUrl);

        $this->assertEquals($signature, 'fd+mOazO9IcjUN/aU3CbU5FzGfDS1tmjuM0s3t63ts4=');
    }

    public function testSignFormContentGet()
    {
        $appId = '8a91e76995b442b7860cb37b7284bced';
        $appSecret = '763865ef4f8d4a72856702527151eed5';
        $timestamp = 1498816901;
        $method = 'GET';
        $baseUrl = 'https://example.app/api/v1/players';
        $parameters = [
            'title'  => 'title',
            'author' => 'ladies-gentlemen',
        ];

        $signature = Signer::signFormContent($appId, $appSecret, $timestamp, $method, $baseUrl, $parameters);

        $this->assertEquals($signature, 'eMi2QXhDztCYRzscmgFFvTGsVqgTzS4x5kqrNyCdYHU=');
    }

    public function testSignFormContentPost()
    {
        $appId = '8a91e76995b442b7860cb37b7284bced';
        $appSecret = '763865ef4f8d4a72856702527151eed5';
        $timestamp = 1498817186;
        $method = 'POST';
        $baseUrl = 'https://example.app/api/v1/players';
        $parameters = [
            'title'      => 'An encoded string!',
            'author'     => 'Ladies + Gentlemen*',
            'publish_at' => 1498815749,
        ];

        $signature = Signer::signFormContent($appId, $appSecret, $timestamp, $method, $baseUrl, $parameters);

        $this->assertEquals($signature, 'GwT5XUYJ3i/zd5T77rOwahbWnm+6cG115SL+4HK6FNA=');
    }

    public function testSignJsonContentGet()
    {
        $appId = '381ec44adb8347c68ea0eb4d43212dab';
        $appSecret = 'ed5a003e2b9846cb8024851e20aaa9be';
        $timestamp = 1498817428;
        $method = 'GET';
        $baseUrl = 'https://example.app/api/v1/players';
        $parameters = [
            'title'  => 'title',
            'author' => 'ladies-gentlemen',
        ];

        $signature = Signer::signJsonContent($appId, $appSecret, $timestamp, $method, $baseUrl, $parameters);

        $this->assertEquals($signature, '49ZCqTHsX/3FfiKeBmiQ5193spkZMjE5yzGZAWOZYmE=');
    }

    public function testSignJsonContentPost()
    {
        $appId = 'c86761be2c644b0db56cc00ab021621a';
        $appSecret = 'ffe877812ab842a1bc30b27751bbd6ac';
        $timestamp = 1498821466;
        $method = 'POST';
        $baseUrl = 'https://example.app/api/v1/players';
        $querys = [
            'title'  => 'title',
            'author' => 'ladies-gentlemen',
        ];
        $body = json_encode([
            'title'      => 'An encoded string!',
            'zbar'       => [
                'coo' => 79,
                'bpp' => 'ddlp',
            ],
            'author'     => 'Ladies + Gentlemen*',
            'publish_at' => 123546987,
            'ary'        => [98, 23, 45, 78],
            'foo'        => 'Dogs, Cats & Mice',
        ]);

        $signature = Signer::signJsonContent($appId, $appSecret, $timestamp, $method, $baseUrl, $querys, $body);

        $this->assertEquals($signature, 'DkIeBgvRkPxHzueBhxRnQSA2Tpzv/5RNuCAgleAFnnc=');
    }

    // public function testSignUnicodeParams()
    // {
    //     $id = '8a91e76995b442b7860cb37b7284bced';
    //     $secret = 'c86761be2c644b0db56cc00ab021621a';
    //     $timestamp = 1497257726;
    //     $baseUrl = 'https://example.app/api/v1/articles';
    //     $parameters = [
    //         'ja' => 'このページでは、295ある全てのウィキペディアを言語のグループ（語族・語派など）で分類した一覧を掲載しています。',
    //         'ko' => '각 언어별 위키백과는 해당 언어 부호(ISO 639)를 wikipedia.org 도메인의 서브도메인으로 사용한다.',
    //         'hi' => 'इस पृष्ट पर आधिकारिक विकिपीडियाओं की पूरी सूची दी गई है',
    //         'kk' => 'Бағандар бойынша өсу не кему ретімен орналастыруға болады',
    //         'zh' => '本頁主要刊登維基百科多種語言的排序的列表，最近一次更新於2015年5月18日',
    //         'pt' => 'O formato das datas não cumpre as normas da Convenção de nomenclatura da Wikipédia',
    //     ];
    //
    //     $signature = Signer::sign($id, $secret, $timestamp, $baseUrl, $parameters);
    //
    //     $this->assertEquals($signature, '5LVp+M4TGuq64OAKY+eYmPqHSCyg4yneN145X+wpw5o=');
    // }
    //
    // public function testCompareTrue()
    // {
    //     $id = 'a963e74344da4bffb8c105187262a4c5';
    //     $secret = '453342fd1ce34f78a0e1872515ebddf1';
    //     $timestamp = 1497258038;
    //     $baseUrl = 'https://example.app/api/v1';
    //     $parameters = [
    //         'foo' => 'bar',
    //     ];
    //
    //     $isCompare = Signer::compare('gR0spTfC2zvofvIovDeRBzDML/Z+148gFIEylYy87FA=', $id, $secret, $timestamp, $baseUrl, $parameters);
    //
    //     $this->assertTrue($isCompare);
    // }
    //
    // public function testCompareFalse()
    // {
    //     $id = 'a963e74344da4bffb8c105187262a4c5';
    //     $secret = '453342fd1ce34f78a0e1872515ebddf1';
    //     $timestamp = 1497258127;
    //     $baseUrl = 'https://example.app/api/v1';
    //
    //     $isCompare = Signer::compare('OxKDCvGSA6yXBF8J6Sv4XRCE8/9y8jMkq56O4SByNtY=', $id, $secret, $timestamp, $baseUrl);
    //
    //     $this->assertFalse($isCompare);
    // }
}
