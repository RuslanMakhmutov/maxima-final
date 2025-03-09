<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use SoapClient;

class CountryInfoServiceApiHelper
{
    private const BASE_URL = 'http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso';
    private SoapClient $client;

    public function __construct()
    {
        $this->client = new SoapClient(self::BASE_URL . '?WSDL');
    }

    public function getContinentsList()
    {
        return Cache::remember(__CLASS__ . __FUNCTION__, 60, function () {
            $res = $this->client->ListOfContinentsByName();
            return $res->ListOfContinentsByNameResult->tContinent;
        });
    }
}
