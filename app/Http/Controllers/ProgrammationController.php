<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Edition;

class ProgrammationController extends Controller
{
    public function index()
    {
        $edition = Edition::getCurrentEdition();

        if (! $edition) {
            return view('lineup', [
                'programmation' => [],
                'stats' => ['total_artistes' => 0, 'total_jours' => 0, 'scenes' => []],
                'allArtistes' => [],
                'edition' => null,
                'error' => 'Aucune édition courante disponible',
            ]);
        }

        // Récupérer tous les artistes actifs de l'édition courante triés par date de début
        $performances = $this->getAllArtistesProg();

        // Grouper par jour réel (basé sur les dates)
        $programmation = $this->groupArtistesByRealDay($performances);

        $allArtistes = $performances
            ->unique('artiste_id')
            ->sortBy('name')
            ->values();

        $stats = [
            'total_artistes' => $allArtistes->count(),
            'total_jours' => count($programmation),
            'scenes' => $performances->pluck('scene')->filter()->unique()->values(),
        ];

        return view('lineup', compact('programmation', 'stats', 'allArtistes', 'edition'));
    }

    public function getAllArtistesProg()
    {
        $edition = Edition::getCurrentEdition();

        if (! $edition) {
            return collect();
        }

        $sourceQuery = DB::table('artistes as a')
            ->join('performances as p', 'a.id', '=', 'p.artiste_id')
            ->join('editions as e', 'p.edition_id', '=', 'e.id')
            ->selectRaw('
        a.id AS artiste_id,
        a.name,
        a.style,
        a.description,
        a.photo,
        a.soundcloud_url,
        a.spotify_url,
        a.youtube_url,
        a.deezer_url,
        p.id AS performance_id,
        p.begin_date,
        p.ending_date,
        p.scene,
        p.day,
        e.year,
        CASE
            WHEN HOUR(p.begin_date) < 12 THEN DATE_SUB(p.begin_date, INTERVAL 1 DAY)
            ELSE p.begin_date
        END AS festival_date
    ')
            ->where('p.actif', 1)
            ->where('e.id', $edition->id);

        $enrichedQuery = DB::query()
            ->fromSub($sourceQuery, 'src')
            ->selectRaw("
        src.artiste_id,
        src.name,
        src.style,
        src.description,
        src.photo,
        src.soundcloud_url,
        src.spotify_url,
        src.youtube_url,
        src.deezer_url,
        src.performance_id,
        src.begin_date,
        src.ending_date,
        src.scene,
        src.day,
        src.year,
        DATE_FORMAT(src.festival_date, '%Y-%m-%d') AS festival_day_key,
        CONCAT(
            DAYNAME(src.festival_date),
            ' ',
            DAYOFMONTH(src.festival_date),
            ' ',
            MONTHNAME(src.festival_date)
        ) AS festival_day_label,
        CONCAT(
            SUBSTRING(DAYNAME(src.festival_date), 1, 3),
            ' ',
            DAYOFMONTH(src.festival_date)
        ) AS festival_day_label_court,
        DATE_FORMAT(src.begin_date, '%H:%i') AS formatted_begin_date,
		DATE_FORMAT(src.ending_date, '%H:%i') AS formatted_ending_date,
        CASE
            WHEN HOUR(src.begin_date) >= 15 AND HOUR(src.begin_date) < 20 THEN '01_afternoon'
            WHEN HOUR(src.begin_date) >= 20 AND HOUR(src.begin_date) < 23 THEN '02_evening'
            WHEN HOUR(src.begin_date) >= 23 OR HOUR(src.begin_date) < 2 THEN '03_night'
            WHEN HOUR(src.begin_date) >= 2 AND HOUR(src.begin_date) < 5 THEN '04_late_night'
            ELSE CONCAT('05_other_', HOUR(src.begin_date))
        END AS period_key,
        CASE
            WHEN HOUR(src.begin_date) >= 15 AND HOUR(src.begin_date) < 20 THEN 'Après-midi festif'
            WHEN HOUR(src.begin_date) >= 20 AND HOUR(src.begin_date) < 23 THEN 'Montée du son'
            WHEN HOUR(src.begin_date) >= 23 OR HOUR(src.begin_date) < 2  THEN 'Au cœur de la nuit'
            WHEN HOUR(src.begin_date) >= 2  AND HOUR(src.begin_date) < 5  THEN 'Les derniers kiffeurs'
            ELSE 'Autres moments'
        END AS period_label,
        CASE
            WHEN HOUR(src.begin_date) >= 15 AND HOUR(src.begin_date) < 20 THEN 1
            WHEN HOUR(src.begin_date) >= 20 AND HOUR(src.begin_date) < 23 THEN 2
            WHEN HOUR(src.begin_date) >= 23 OR HOUR(src.begin_date) < 2 THEN 3
            WHEN HOUR(src.begin_date) >= 2 AND HOUR(src.begin_date) < 5 THEN 4
            ELSE 5
        END AS period_sort_order,
        CASE
            WHEN HOUR(src.begin_date) >= 15 AND HOUR(src.begin_date) < 20 THEN '15h - 20h'
            WHEN HOUR(src.begin_date) >= 20 AND HOUR(src.begin_date) < 23 THEN '20h - 23h'
            WHEN HOUR(src.begin_date) >= 23 OR HOUR(src.begin_date) < 2 THEN '23h - 02h'
            WHEN HOUR(src.begin_date) >= 2 AND HOUR(src.begin_date) < 5 THEN '02h - 05h'
            ELSE 'Autres créneaux'
        END AS period_time_range,
        CASE
            WHEN HOUR(src.begin_date) >= 15 AND HOUR(src.begin_date) < 20 THEN '☀️'
            WHEN HOUR(src.begin_date) >= 20 AND HOUR(src.begin_date) < 23 THEN '🌅'
            WHEN HOUR(src.begin_date) >= 23 OR HOUR(src.begin_date) < 2  THEN '🌙'
            WHEN HOUR(src.begin_date) >= 2  AND HOUR(src.begin_date) < 5  THEN '✨'
            ELSE '🎵'
        END AS period_Icon,
        CASE
            WHEN src.scene LIKE 'Extérieur' THEN 'bg-[#FF0F63]'
            ELSE 'bg-[#8F1E98]'
        END AS sceneColor,
        CASE
            WHEN src.scene LIKE 'Extérieur' THEN '🌟'
            ELSE '🏠'
        END AS sceneIcon
    ");

        return DB::query()
            ->fromSub($enrichedQuery, 'enriched')
            ->selectRaw("
        enriched.*,
        DENSE_RANK() OVER (ORDER BY enriched.festival_day_key) AS day_order,
        CASE DENSE_RANK() OVER (ORDER BY enriched.festival_day_key)
            WHEN 1 THEN 'bg-[#FF0F63]'
            WHEN 2 THEN 'bg-[#8F1E98]'
            WHEN 3 THEN 'bg-[#272AC7]'
            ELSE 'bg-gray-500'
        END AS day_color
    ")
            ->orderBy('festival_day_key')
            ->orderBy('period_sort_order')
            ->orderBy('begin_date')
            ->get();
    }

    /**
     * Grouper les artistes par jour réel en tenant compte de la continuité jour/nuit
     */
    private function groupArtistesByRealDay($artistes)
    {
        $grouped = [];

        foreach ($artistes as $artiste) {
            $dayKey = $artiste->festival_day_key;
            $periodKey = $artiste->period_key;

            if (! isset($grouped[$dayKey])) {
                $grouped[$dayKey] = [
                    'label' => $artiste->festival_day_label,
                    'date' => $artiste->festival_day_key,
                    'periods' => [],
                ];
            }

            if (! isset($grouped[$dayKey]['periods'][$periodKey])) {
                $grouped[$dayKey]['periods'][$periodKey] = [
                    'label' => $artiste->period_label,
                    'time_range' => $artiste->period_time_range,
                    'sort_order' => $artiste->period_sort_order,
                    'period_Icon' => $artiste->period_Icon,
                    'artistes' => [],
                ];
            }

            $grouped[$dayKey]['periods'][$periodKey]['artistes'][] = $artiste;
        }

        return $grouped;
    }
}
