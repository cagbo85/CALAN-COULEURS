<?php

namespace App\Http\Controllers;

use App\Models\Edition;
use Illuminate\Support\Facades\DB;

class PartenaireController extends Controller
{
    /**
     * Récupérer les partenaires pour l'édition courante UNIQUEMENT
     */
    public function getPartenairesCurrentEdition()
    {
        $currentEdition = Edition::getCurrentEdition();

        if (! $currentEdition) {
            return response()->json([
                'message' => 'Aucune édition courante disponible',
            ], 404);
        }

        $partenaires = DB::table('partenaires as p')
            ->join('edition_partenaires as ep', 'p.id', '=', 'ep.partenaire_id')
            ->join('editions as e', 'ep.edition_id', '=', 'e.id')
            ->select('p.*', 'e.year')
            ->where('ep.actif', 1)
            ->where('e.id', $currentEdition->id)
            ->orderBy('p.ordre')
            ->get();

        return response()->json($partenaires);
    }
}
