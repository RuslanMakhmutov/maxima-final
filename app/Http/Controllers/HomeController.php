<?php

namespace App\Http\Controllers;

use App\Helpers\CountryInfoServiceApiHelper;
use App\Helpers\OpenWeatherApiHelper;
use App\Services\PollutionService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke(
        OpenWeatherApiHelper $openWeatherApiHelper,
        CountryInfoServiceApiHelper $countryInfoHelper,
        PollutionService $pollutionService,
    ) {
        if (Auth::check() && $city = Auth::user()->city) {
            try {
                $air = $openWeatherApiHelper->getAirPollution($city);
                $pollution = $pollutionService->saveAirResponse($air);
            } catch (\Throwable $th) {
                report($th);
            }
        }

        return Inertia::render('Home/Home', [
            'pollution' => $pollution ?? null,
            'continents' => $countryInfoHelper->getContinentsList(),
        ]);
    }
}
