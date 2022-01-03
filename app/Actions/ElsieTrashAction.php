<?php

namespace App\Actions;

use Exception;

class ElsieTrashAction extends CookieAction
{
    protected string $url = 'http://elsie.ua/rus/shop/trash.html';
    protected int $shop = 1;

    protected static int $MAX_COUNT = 1000;

    /**
     * @throws Exception
     */
    public function handle(array $codes = [], bool $filled = false, array $stocks = []): string
    {
        $this->setCredentials();
        return $this->getResponse($codes, $filled, $stocks);
    }

    protected function getPostFields(array $codes, bool $filled, array $stocks): string
    {
        return implode('&', [
            'shop=1',
            collect($codes)->map(function (string $code) use ($filled) {
                return implode('=', [
                    $code,
                    $filled ? self::$MAX_COUNT : 0,
                ]);
            })->implode('&'),
        ]);
    }

    protected function getResponse($codes, $filled, $sctocks): bool|string
    {
        $curl = curl_init($this->url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->getPostFields($codes, $filled, $sctocks),
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => [
                'Connection: keep-alive',
                'Pragma: no-cache',
                'Cache-Control: no-cache',
                'Upgrade-Insecure-Requests: 1',
                'Origin: http://elsie.ua',
                'Content-Type: application/x-www-form-urlencoded',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'Referer: http://elsie.ua/ukr/shop/items.html',
                'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6',
                implode(': ', [
                    'Cookie',
                    $this->credentials->header_value,
                ]),
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
