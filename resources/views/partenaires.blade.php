@extends('layouts.app')

@section('content')
<main class="w-full">
    {{-- Section partenaires dynamique --}}
    <div id="partners-root" aria-live="polite"></div>
</main>
@endsection

@push('scripts')
    @vite(['resources/js/partners-loader.jsx'])
@endpush
