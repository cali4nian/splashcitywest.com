@props(['alt' => config('app.name', 'Charlie Ross').' logo'])

<img src="{{ asset('images/logo.png') }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => 'object-contain']) }}>
