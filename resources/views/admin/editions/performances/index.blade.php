@extends('layouts.admin')

<head>
    <title>Performances - {{ $edition->name ?? 'Édition ' . $edition->year }} - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">

            <!-- Bandeau édition -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="relative h-48"
                    style="background: linear-gradient(135deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%);">
                    <div class="absolute top-4 left-4 z-40">
                        <a href="{{ route('admin.editions.show', $edition->id) }}"
                            class="bg-black bg-opacity-30 text-white px-4 py-2 rounded-lg hover:bg-opacity-50 transition-all flex items-center">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            Retour à l'édition
                        </a>
                    </div>

                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h1 class="text-2xl font-bold">
                                <i class="fa-solid fa-microphone mr-2 opacity-80"></i>
                                Performances - {{ $edition->name ?? 'Édition ' . $edition->year }}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-5 border border-gray-200 flex items-center gap-4">
                    <div class="w-11 h-11 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-microphone text-purple-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Performances programmées</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $performancesAssocies->count() }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-5 border border-gray-200 flex items-center gap-4">
                    <div class="w-11 h-11 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-eye text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Performances visibles sur le site</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $performancesAssocies->where('actif', 1)->count() }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-5 border border-gray-200 flex items-center gap-4">
                    <div class="w-11 h-11 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user-plus text-gray-500 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Artistes disponibles pour performer</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $performancesDisponibles->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Performances de cette édition -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-microphone text-purple-500"></i>
                        Performances présentes
                        <span class="ml-1 text-sm font-normal text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                            {{ $performancesAssocies->count() }}
                        </span>
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Performances programmées pour cette édition.</p>
                </div>

                @if ($performancesAssocies->isEmpty())
                    <div class="p-12 text-center text-gray-400">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-microphone-slash text-gray-300 text-2xl"></i>
                        </div>
                        <p class="font-medium text-gray-500">Aucune performance programmée pour cette édition</p>
                        <p class="text-sm mt-1">Ajoutez des performances depuis la section ci-dessous.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Artiste
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Style
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Programmation
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Scène
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Visible
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left w-20 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($performancesAssocies as $performance)
                                    <tr class="hover:bg-gray-50">
                                        <!-- Artiste -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                @if ($performance->photo)
                                                    <img src="{{ asset($performance->photo) }}"
                                                        alt="{{ $performance->name }}"
                                                        class="h-10 w-10 rounded-full object-cover flex-shrink-0">
                                                @else
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                                        <i class="fa-solid fa-microphone text-purple-400 text-sm"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('admin.artistes.show', $performance->artiste_id) }}"
                                                        class="text-sm font-medium text-gray-900 hover:text-purple-600 transition-colors">
                                                        {{ $performance->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Style -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($performance->style)
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $performance->style }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Programmation -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            @if ($performance->day)
                                                <div class="font-medium capitalize">{{ $performance->day }}</div>
                                            @endif
                                            @if ($performance->begin_date && $performance->ending_date)
                                                <div class="text-xs text-gray-400">
                                                    {{ $performance->formatted_begin_date }}
                                                    -
                                                    {{ $performance->formatted_ending_date }}
                                                </div>
                                            @endif
                                            @if (!$performance->day && !$performance->begin_date && !$performance->ending_date)
                                                <span class="text-gray-400 text-xs">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Scène -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            @if ($performance->scene)
                                                <span
                                                    class="ml-1 inline-flex px-2 py-0.5 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">
                                                    {{ $performance->scene }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Visible -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($performance->actif)
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="fa-solid fa-eye"></i> Oui
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500">
                                                    <i class="fa-solid fa-eye-slash"></i> Non
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Action -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-2 justify-between">
                                                <!-- Voir -->
                                                <a href="{{ route('admin.artistes.show', $performance->artiste_id) }}"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors"
                                                    title="Voir">
                                                    <i class="fa-solid fa-eye"></i>
                                                    Voir
                                                </a>

                                                @if ($performance->actif)
                                                    <!-- Masquer -->
                                                    <form method="POST"
                                                        action="{{ route('admin.editions.performances.hide', [$edition->id, $performance->artiste_id]) }}"
                                                        onsubmit="return confirm('Êtes-vous sûr de vouloir masquer la performance de cet(te) artiste ? Il/Elle ne sera plus visible publiquement.')">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-orange-500 hover:text-white border border-orange-600 hover:bg-orange-600 rounded-lg transition-colors">
                                                            <i class="fa-solid fa-eye-slash"></i>
                                                            Masquer
                                                        </button>
                                                    </form>
                                                @else
                                                    <!-- Rendre visible -->
                                                    <form method="POST"
                                                        action="{{ route('admin.editions.performances.show', [$edition->id, $performance->artiste_id]) }}"
                                                        onsubmit="return confirm('Êtes-vous sûr de vouloir rendre visible la performance de cet(te) artiste ? Il/Elle sera de nouveau visible publiquement.')">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-green-500 hover:text-white border border-green-600 hover:bg-green-600 rounded-lg transition-colors">
                                                            <i class="fa-solid fa-eye"></i>
                                                            Activer
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Supprimer -->
                                                <form method="POST"
                                                    action="{{ route('admin.editions.performances.delete', [$edition->id, $performance->performance_id]) }}"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer la performance de cet(te) artiste ? Cette action est irréversible.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-500 hover:text-white border border-red-600 hover:bg-red-600 rounded-lg transition-colors">
                                                        <i class="fa-solid fa-trash"></i>
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Artistes disponibles -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-gray-400"></i>
                        Artistes disponibles
                        <span class="ml-1 text-sm font-normal text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                            {{ $performancesDisponibles->count() }}
                        </span>
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Artistes non programmés pour cette édition.</p>
                </div>

                @if ($performancesDisponibles->isEmpty())
                    <div class="p-12 text-center text-gray-400">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-check text-green-400 text-2xl"></i>
                        </div>
                        <p class="font-medium text-gray-500">Tous les artistes sont déjà programmés !</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Artiste
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Style
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($performancesDisponibles as $performance)
                                    <tr class="hover:bg-gray-50">
                                        <!-- Artiste -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                @if ($performance->photo)
                                                    <img src="{{ asset($performance->photo) }}"
                                                        alt="{{ $performance->name }}"
                                                        class="h-10 w-10 rounded-full object-cover flex-shrink-0 grayscale">
                                                @else
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                                                        <i class="fa-solid fa-microphone text-gray-300 text-sm"></i>
                                                    </div>
                                                @endif
                                                <a href="{{ route('admin.artistes.show', $performance->id) }}"
                                                    class="text-sm font-medium text-gray-700 hover:text-purple-600 transition-colors">
                                                    {{ $performance->name }}
                                                </a>
                                            </div>
                                        </td>

                                        <!-- Style -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($performance->style)
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $performance->style }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Action -->
                                        <td class="px-6 py-4 whitespace-nowrap text-left">
                                            <form method="POST"
                                                action="{{ route('admin.editions.performances.attach', [$edition->id, $performance->id]) }}"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir ajouter cet(te) artiste à l\'édition ?')">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">
                                                    <i class="fa-solid fa-plus"></i>
                                                    Ajouter
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </main>
@endsection
