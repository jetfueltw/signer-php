<?php

use Jetfuel\Signer\Signer;

class Test extends PHPUnit_Framework_TestCase
{
    public function testSignGetEmptyData()
    {
        $appId = 'ed5a003e2b9846cb8024851e20aaa9be';
        $appSecret = '8a91e76995b442b7860cb37b7284bced';
        $timestamp = 1499054773;
        $method = 'GET';
        $baseUrl = 'https://example.app/api/v1';

        $signature = Signer::sign($appId, $appSecret, $timestamp, $method, $baseUrl);

        $this->assertEquals($signature, 'BVfCg0Vg5fX2ohcLl8PKtP1g07XNRK038Co+ROJrhd0=');
    }

    public function testSignPostEmptyData()
    {
        $appId = '8a91e76995b442b7860cb37b7284bced';
        $appSecret = '763865ef4f8d4a72856702527151eed5';
        $timestamp = 1499054711;
        $method = 'POST';
        $baseUrl = 'https://example.app/api/v1';

        $signature = Signer::sign($appId, $appSecret, $timestamp, $method, $baseUrl);

        $this->assertEquals($signature, 'sL4Xq+coGrlSybyyVsjf+L7am2JiGrWhtqMYoMgWlMw=');
    }

    public function testSignGet()
    {
        $appId = '381ec44adb8347c68ea0eb4d43212dab';
        $appSecret = 'ed5a003e2b9846cb8024851e20aaa9be';
        $timestamp = 1499056693;
        $method = 'GET';
        $baseUrl = 'https://example.app/api/v1/players';
        $parameters = [
            'title'      => 'title!',
            'author'     => 'Ladies + Gentlemen',
            'publish_at' => 123546987,
        ];

        $signature = Signer::sign($appId, $appSecret, $timestamp, $method, $baseUrl, $parameters);

        $this->assertEquals($signature, 'm7sUr6p+qxpLy+P4/3i+Jjm3bDlthuXlWWlXyPmQP3w=');
    }

    public function testSignPost()
    {
        $appId = 'c86761be2c644b0db56cc00ab021621a';
        $appSecret = 'ffe877812ab842a1bc30b27751bbd6ac';
        $timestamp = 1499158061;
        $method = 'POST';
        $baseUrl = 'https://example.app/api/v1/players';
        $parameters = [
            'title'      => 'title!',
            'author'     => 'Ladies + Gentlemen',
            'publish_at' => 123546987,
        ];
        $content = json_encode([
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

        $signature = Signer::sign($appId, $appSecret, $timestamp, $method, $baseUrl, $parameters, $content);

        $this->assertEquals($signature, 'oNuThaOk/fTFzKMNTXU41j20lu//teREvjjOhxLDcL0=');
    }

    public function testSignPostUnicode()
    {
        $appId = 'c86761be2c644b0db56cc00ab021621a';
        $appSecret = '8a91e76995b442b7860cb37b7284bced';
        $timestamp = 1499056301;
        $method = 'POST';
        $baseUrl = 'https://example.app/api/v1/articles';
        $parameters = [
            'ja' => 'このページでは、295ある全てのウィキペディアを言語のグループ（語族・語派など）で分類した一覧を掲載しています。',
            'ko' => '각 언어별 위키백과는 해당 언어 부호(ISO 639)를 wikipedia.org 도메인의 서브도메인으로 사용한다.',
        ];
        $content = json_encode([
            'hi' => 'इस पृष्ट पर आधिकारिक विकिपीडियाओं की पूरी सूची दी गई है',
            'kk' => 'Бағандар бойынша өсу не кему ретімен орналастыруға болады',
            'zh' => '本頁主要刊登維基百科多種語言的排序的列表，最近一次更新於2015年5月18日',
            'pt' => 'O formato das datas não cumpre as normas da Convenção de nomenclatura da Wikipédia',
        ]);

        $signature = Signer::sign($appId, $appSecret, $timestamp, $method, $baseUrl, $parameters, $content);

        $this->assertEquals($signature, 'WkOchGPoKKPLL9006NneJK+mOx4T1CfeknD7iNlSJ0k=');
    }

    public function testCompare()
    {
        $appId = 'a963e74344da4bffb8c105187262a4c5';
        $appSecret = '453342fd1ce34f78a0e1872515ebddf1';
        $timestamp = 1499057241;
        $method = 'GET';
        $baseUrl = 'https://example.app/api/v1';
        $parameters = [
            'foo' => 'bar',
        ];

        $isCompare = Signer::compare('n5VRiFMIUX50Zis0ghGIeySi64W6ZzY+82SURT9i+mk=', $appId, $appSecret, $timestamp, $method, $baseUrl, $parameters);

        $this->assertTrue($isCompare);
    }

    // public function testUrlEncode()
    // {
    //     $url = Signer::urlEncode('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ !@#$%^&*()-_=+:;."\'\\/?<>~[]{}`');
    //
    //     $this->assertEquals($url, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ%20%21%40%23%24%25%5E%26%2A%28%29-_%3D%2B%3A%3B.%22%27%5C%2F%3F%3C%3E~%5B%5D%7B%7D%60');
    // }

    // public function testBuildParameterString()
    // {
    //     $parameterString = Signer::buildParameterString([
    //         'e' => '0123456789',
    //         'a' => 'abcdefghijklmnopqrstuvwxyz',
    //         'b' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    //         'c' => ' !@#$%^&*()-_=+:;',
    //         'd' => '."\'\\/?<>~[]{}`'
    //     ]);
    //
    //     $this->assertEquals($parameterString, 'a=abcdefghijklmnopqrstuvwxyz&b=ABCDEFGHIJKLMNOPQRSTUVWXYZ&c=%20%21%40%23%24%25%5E%26%2A%28%29-_%3D%2B%3A%3B&d=.%22%27%5C%2F%3F%3C%3E~%5B%5D%7B%7D%60&e=0123456789');
    // }

    // public function testRemoveQueryString()
    // {
    //     $url = Signer::removeQueryString('https://example.app/api/v1/players/?foo=bar&key=value#title');
    //
    //     $this->assertEquals($url, 'https://example.app/api/v1/players');
    // }

    // public function testRemoveLineBreak()
    // {
    //     $content = '{
    //         "title": "An e    ncoded string!",
    //         "zbar": {
    //
    //                     "coo": 79,
    //             "bpp": "ddlp"
    //         },
    //
    //
    //              "author": "Ladies +   Gentlemen*",
    //              "publish_at": 123546987,
    //
    //  "ary": [98, 23, 45,   78],
    //                     "foo": "Dogs, Cats & Mice"
    //     }';
    //
    //     $content = Signer::removeLineBreak($content);
    //
    //     $this->assertEquals($content, '{"title":"Anencodedstring!","zbar":{"coo":79,"bpp":"ddlp"},"author":"Ladies+Gentlemen*","publish_at":123546987,"ary":[98,23,45,78],"foo":"Dogs,Cats&Mice"}');
    // }
}
