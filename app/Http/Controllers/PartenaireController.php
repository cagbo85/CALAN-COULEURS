<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PartenaireController extends Controller
{
    public function getAllPartenaires()
    {
        $partenaires = DB::table('partenaires')
            ->where('actif', 1)
            ->where('annee', 2025)
            ->orderBy('ordre')
            ->get();

        return response()->json($partenaires);
    }
}
