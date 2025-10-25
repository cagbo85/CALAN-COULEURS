<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Artiste;
use Illuminate\Support\Facades\DB;

class ProgrammationController extends Controller
{
    public function index()
    {
        // Récupérer tous les artistes actifs triés par date de début
        $allArtistes = DB::table('artistes as a')
            ->join('edition_artistes as ea', 'a.id', '=', 'ea.artiste_id')
            ->join('editions as e', 'ea.edition_id', '=', 'e.id')
            ->select('a.*', 'e.year')
            ->where('ea.actif', 1)
            ->where('e.actif', 1)
            ->orderBy('a.begin_date')
            ->get();

        // Grouper par jour réel (basé sur les dates)
        $programmation = $this->groupArtistesByRealDay($allArtistes);

        // Statistiques pour l'affichage
        $stats = [
            'total_artistes' => $allArtistes->count(),
            'total_jours' => count($programmation),
            'scenes' => $allArtistes->pluck('scene')->filter()->unique()->values(),
        ];

        return view('lineup', compact('programmation', 'stats', 'allArtistes'));
    }

    /**
     * Grouper les artistes par jour réel en tenant compte de la continuité jour/nuit
     */
    private function groupArtistesByRealDay($artistes)
    {
        $grouped = [];

        foreach ($artistes as $artiste) {
            $beginDate = Carbon::parse($artiste->begin_date);

            // Créer la clé du jour
            $dayKey = $this->getFestivalDayKey($beginDate);

            if (! isset($grouped[$dayKey])) {
                $grouped[$dayKey] = [
                    'label' => $this->getFestivalDayLabel($beginDate),
                    'date' => $beginDate->format('Y-m-d'),
                    'periods' => [],
                ];
            }

            // ✅ UTILISER L'HEURE COMPLÈTE POUR LE TRI
            $periodKey = $this->getPeriodKey($beginDate);
            $periodLabel = $this->getPeriodLabel($beginDate);

            if (! isset($grouped[$dayKey]['periods'][$periodKey])) {
                $grouped[$dayKey]['periods'][$periodKey] = [
                    'label' => $periodLabel,
                    'time_range' => $this->getPeriodTimeRange($periodLabel),
                    'sort_order' => $this->getPeriodSortOrder($periodLabel),
                    'artistes' => [],
                ];
            }

            $grouped[$dayKey]['periods'][$periodKey]['artistes'][] = $artiste;
        }

        // ✅ TRIER LES PÉRIODES PAR ORDRE CHRONOLOGIQUE
        foreach ($grouped as &$day) {
            uasort($day['periods'], function ($a, $b) {
                return $a['sort_order'] <=> $b['sort_order'];
            });

            // Trier les artistes dans chaque période par heure de début
            foreach ($day['periods'] as &$period) {
                usort($period['artistes'], function ($a, $b) {
                    return Carbon::parse($a->begin_date)->timestamp <=> Carbon::parse($b->begin_date)->timestamp;
                });
            }
        }

        return $grouped;
    }

    /**
     * Obtenir la clé unique de période basée sur l'heure de début
     */
    private function getPeriodKey($date)
    {
        $carbon = Carbon::parse($date);
        $hour = $carbon->hour;

        // Créer une clé unique qui préserve l'ordre chronologique
        if ($hour >= 15 && $hour < 20) {
            return '01_afternoon';
        }
        if ($hour >= 20 && $hour < 23) {
            return '02_evening';
        }
        if ($hour >= 23 || $hour < 2) {
            return '03_night';
        }
        if ($hour >= 2 && $hour < 5) {
            return '04_late_night';
        }

        return '05_other_'.$hour;
    }

    /**
     * Obtenir la clé du jour festival
     */
    private function getFestivalDayKey($date)
    {
        $carbon = Carbon::parse($date);

        if ($carbon->hour < 12) {
            return $carbon->subDay()->format('Y-m-d');
        }

        return $carbon->format('Y-m-d');
    }

    /**
     * Obtenir le libellé du jour festival
     */
    private function getFestivalDayLabel($date)
    {
        $carbon = Carbon::parse($date);

        if ($carbon->hour < 12) {
            $carbon->subDay();
        }

        $dayNames = [
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche',
        ];

        $dayName = $dayNames[$carbon->format('l')] ?? $carbon->format('l');

        return $dayName.' '.$carbon->format('j').' septembre';
    }

    /**
     * Obtenir la période de la journée
     */
    private function getPeriodLabel($date)
    {
        $hour = Carbon::parse($date)->hour;

        if ($hour >= 15 && $hour < 20) {
            return 'afternoon';
        }
        if ($hour >= 20 && $hour < 23) {
            return 'evening';
        }
        if ($hour >= 23 || $hour < 2) {
            return 'night';
        }
        if ($hour >= 2 && $hour < 5) {
            return 'late_night';
        }

        return 'other';
    }

    /**
     * ✅ NOUVEAU : Obtenir l'ordre de tri pour les périodes
     */
    private function getPeriodSortOrder($period)
    {
        $orders = [
            'afternoon' => 1,
            'evening' => 2,
            'night' => 3,
            'late_night' => 4,
            'other' => 5,
        ];

        return $orders[$period] ?? 99;
    }

    /**
     * Obtenir la plage horaire de la période
     */
    private function getPeriodTimeRange($period)
    {
        $ranges = [
            'afternoon' => '15h - 20h',
            'evening' => '20h - 23h',
            'night' => '23h - 02h',
            'late_night' => '02h - 05h',
            'other' => 'Autres créneaux',
        ];

        return $ranges[$period] ?? 'Horaires variables';
    }
}
