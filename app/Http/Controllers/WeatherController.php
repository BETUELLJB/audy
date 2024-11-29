<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function showWeather(Request $request)
    {
        $city = $request->input('city', 'Chibuto'); // Cidade padrão
        $apiKey = env('TOMORROW_API_KEY'); // Chave da API da Tomorrow.io

        // Obter as coordenadas da cidade
        $coordinates = $this->getCoordinates($city);

        if (!$coordinates) {
            return view('weather.index', [
                'error' => "Não foi possível obter as coordenadas para a cidade: {$city}",
                'city' => $city,
                'weather' => null,
            ]);
        }

        // Cache para armazenar a resposta da API por 1 hora (3600 segundos)
        $weather = Cache::remember("weather_{$city}", 3600, function () use ($coordinates, $apiKey) {
            $response = Http::get("https://api.tomorrow.io/v4/weather/realtime", [
                'location' => "{$coordinates['lat']},{$coordinates['lon']}", // Use lat e lon
                'apikey' => $apiKey,
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            // Verificar se a resposta foi bem-sucedida e retornar os dados
            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });

        // Verifica se a API retornou dados válidos
        if (!$weather || !isset($weather['data'])) {
            return view('weather.index', [
                'error' => 'Não foi possível obter os dados de previsão do clima.',
                'city' => $city,
                'weather' => null,
            ]);
        }

        // Dados do clima em tempo real
        $weatherData = $weather['data']['values'];

        return view('weather.index', [
            'weather' => $weatherData,
            'city' => $city,
            'error' => null,
        ]);
    }

    private function getCoordinates($city)
    {
        // Exemplo usando a API OpenCage para obter coordenadas
        $response = Http::get('https://api.opencagedata.com/geocode/v1/json', [
            'q' => $city,
            'key' => env('GEOCODING_API_KEY'),
            'limit' => 1,
        ]);

        if ($response->successful() && isset($response->json()['results'][0]['geometry'])) {
            return [
                'lat' => $response->json()['results'][0]['geometry']['lat'],
                'lon' => $response->json()['results'][0]['geometry']['lng'], // OpenCage usa 'lng' em vez de 'lon'
            ];
        }

        return null; // Retorna null se não houver dados válidos
    }
}
