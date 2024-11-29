@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-white">
                <div class="card-body text-center" style="color: black; background-image: url('/images/weather-bg.jpg'); background-size: cover; background-position: center; border-radius: 15px;">
                    <h2 class="mb-4">Previsão do Clima em {{ ucfirst($city) }}</h2>

                    @if($error)
                        <p class="text-danger">{{ $error }}</p>
                    @elseif(isset($weather))
                        <p class="h4 mb-3">
                            <i class="fas fa-temperature-high"></i> Temperatura: {{ $weather['temperature'] }}°C
                        </p>
                        <p class="h5 mb-3">
                            <i class="fas fa-tint"></i> Humidade: {{ $weather['humidity'] }}%
                        </p>
                        <p class="h5">
                            <i class="fas fa-wind"></i> Velocidade do Vento: {{ $weather['windSpeed'] }} m/s
                        </p>
                    @else
                        <p class="text-danger">Não foi possível obter os dados do clima.</p>
                    @endif

                    <form method="GET" action="{{ route('weather.show') }}" class="mt-4">
                        <div class="input-group">
                            <input type="text" name="city" class="form-control" placeholder="Digite o nome da cidade" value="{{ old('city', $city) }}">
                            <button class="btn btn-primary" type="submit">Procurar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
