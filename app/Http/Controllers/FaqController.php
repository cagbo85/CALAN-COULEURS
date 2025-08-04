<?php
// filepath: app/Http/Controllers/FaqController.php
namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function getAllFaqs()
    {
        $faqs = DB::table('faqs')
            ->select('id', 'question', 'answer', 'actif', 'ordre', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->where('actif', true)
            ->orderBy('ordre')
            ->get();

        return response()->json($faqs);
    }
}
