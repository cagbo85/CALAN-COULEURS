<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StandController extends Controller
{
    public function getAllStands()
    {
        $stands = DB::table('stands')
            ->select('id', 'name', 'description', 'photo', 'type', 'instagram_url', 'facebook_url', 'website_url', 'other_link', 'actif', 'ordre', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->where('actif', 1)
            ->where('year', 2025)
            ->orderBy('ordre')
            ->get();

        return response()->json($stands);
    }
}
