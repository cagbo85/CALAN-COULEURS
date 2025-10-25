<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PartenaireController extends Controller
{
    /**
     * Récupérer tous les partenaires actifs pour l'édition active.
     */
    public function getAllPartenaires()
    {
        $partenaires = DB::table('partenaires as p')
            ->join('edition_partenaires as ep', 'p.id', '=', 'ep.partenaire_id')
            ->join('editions as e', 'ep.edition_id', '=', 'e.id')
            ->select('p.*', 'e.year')
            ->where('ep.actif', 1)
            ->where('e.actif', 1)
            ->orderBy('p.ordre')
            ->get();

        return response()->json($partenaires);
    }
}
