<?php

namespace App\Http\Controllers;

use App\Models\Edition;
use Illuminate\Support\Facades\DB;

class StandController extends Controller
{
    /**
     * Récupérer tous les stands actifs pour l'édition active.
     */
    public function getAllStands()
    {
        $stands = DB::table('stands as s')
            ->join('edition_stands as es', 's.id', '=', 'es.stand_id')
            ->join('editions as e', 'es.edition_id', '=', 'e.id')
            ->select('s.*', 'e.year')
            ->where('es.actif', 1)
            ->where('e.actif', 1)
            ->orderBy('s.ordre')
            ->get();

        return response()->json($stands);
    }

    /**
     * Récupérer les stands pour l'édition courante UNIQUEMENT
     */
    public function getStandsCurrentEdition()
    {
        $currentEdition = Edition::getCurrentEdition();

        if (! $currentEdition) {
            return response()->json([
                'message' => 'Aucune édition courante disponible',
            ], 404);
        }

        $stands = DB::table('stands as s')
            ->join('edition_stands as es', 's.id', '=', 'es.stand_id')
            ->join('editions as e', 'es.edition_id', '=', 'e.id')
            ->select('s.*', 'e.year')
            ->where('es.actif', 1)
            ->where('e.id', $currentEdition->id)
            ->orderBy('s.ordre')
            ->get();

        return response()->json($stands);
    }
}
