<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class EditionController extends Controller
{
    /**
     * Récupérer l'édition active avec ses détails. Version API.
     */
    public function getAllActiveEditions()
    {
        $editions = DB::table('editions as e')
            ->select('e.*')
            ->where('e.actif', 1)
            ->get();

        return response()->json($editions);
    }

    /**
     * Récupérer l'édition active avec ses détails.
     */
    public function getActiveEdition()
    {
        $edition = DB::table('editions as e')
            ->select('e.*')
            ->where('e.actif', 1)
            ->first();

        return $edition;
    }
}
