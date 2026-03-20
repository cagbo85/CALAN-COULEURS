@extends('layouts.app')

@section('title', 'Partenaires - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('content')
<main class="w-full">
    <div id="partners-root" aria-live="polite"></div>
</main>
@endsection

@push('scripts')
    @vite(['resources/js/partners-loader.jsx'])
@endpush
