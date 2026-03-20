<?php

namespace App\Console\Commands;

use App\Models\Edition;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateEditionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'editions:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mettre à jour automatiquement le statut des éditions en fonction des dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des statuts des éditions...');

        $now = now();
        Log::info("Début de la mise à jour des statuts des éditions à {$now}");
        $editions = Edition::where('actif', true)
            ->whereNotIn('status', ['draft', 'archived'])
            ->orderBy('begin_date', 'desc')
            ->get();
        foreach ($editions as $edition) {
            Log::info("Edition ID: {$edition->id}, Name: {$edition->name}, Current Status: {$edition->status}, Begin Date: {$edition->begin_date}, Ending Date: {$edition->ending_date}");
        }
        $updatedCount = 0;

        $phaseB = null;

        foreach ($editions as $edition) {
            $newStatus = null;
            Log::info("Vérification de l'édition ID: {$edition->id} ({$edition->name}) pour déterminer la Phase B...");

            if ($now->lt($edition->begin_date)) {
                $newStatus = 'upcoming';
                Log::info("{$edition->name} (ID: {$edition->id}) est passée à 'À venir'");
            } elseif ($now->gte($edition->begin_date) && $now->lt($edition->ending_date)) {
                $newStatus = 'ongoing';
                Log::info("{$edition->name} (ID: {$edition->id}) est passée à 'En cours'");
            } elseif ($now->gte($edition->ending_date)) {
                $newStatus = 'past';
                Log::info("{$edition->name} (ID: {$edition->id}) est passée à 'Passée'");
            }

            if ($newStatus && in_array($newStatus, ['upcoming', 'ongoing', 'past'])) {
                Log::info("{$edition->name} (ID: {$edition->id}) est en Phase B");
                $phaseB = $edition->id;
                Log::info("Phase B définie sur l'édition ID: {$edition->id} ({$edition->name})");
                break;
            }
        }

        foreach ($editions as $edition) {
            $newStatus = null;

            Log::info("Traitement de l'édition ID: {$edition->id} ({$edition->name}) pour mise à jour du statut...");
            if ($now->lt($edition->begin_date)) {
                $newStatus = 'upcoming';
                Log::info("{$edition->name} (ID: {$edition->id}) est passée à 'À venir'");
            } elseif ($now->gte($edition->begin_date) && $now->lt($edition->ending_date)) {
                $newStatus = 'ongoing';
                Log::info("{$edition->name} (ID: {$edition->id}) est passée à 'En cours'");
            } elseif ($now->gte($edition->ending_date)) {
                $newStatus = 'past';
                Log::info("{$edition->name} (ID: {$edition->id}) est passée à 'Passée'");
            }

            if ($newStatus && $newStatus !== $edition->status) {
                $oldStatus = $edition->status;
                Log::info("Mise à jour de l'édition ID: {$edition->id} ({$edition->name}) du statut '{$oldStatus}' au statut '{$newStatus}'");
                $edition->update(['status' => $newStatus]);
                Log::info("Mise à jour réussie pour l'édition ID: {$edition->id} ({$edition->name}) : '{$oldStatus}' → '{$newStatus}'");
                $this->info("{$edition->name} : '{$oldStatus}' → '{$newStatus}'");
                Log::info("Mise à jour terminée pour l'édition ID: {$edition->id} ({$edition->name})");
                $updatedCount++;
            } elseif (!$newStatus && $edition->id !== $phaseB) {
                if (in_array($edition->status, ['upcoming', 'ongoing', 'past'])) {
                    $edition->update(['status' => 'archived']);
                    Log::info("L'édition ID: {$edition->id} ({$edition->name}) n'est plus en Phase B et a été archivée");
                    $this->info("{$edition->name} : '{$edition->status}' → 'archived'");
                    Log::info("Mise à jour terminée pour l'édition ID: {$edition->id} ({$edition->name}) : '{$edition->status}' → 'archived'");
                    $updatedCount++;
                }
            }
        }

        if ($updatedCount === 0) {
            Log::info('Aucune édition à mettre à jour.');
            $this->info('Aucune édition à mettre à jour.');
        } else {
            Log::info("Mise à jour terminée pour {$updatedCount} édition(s).");
            $this->info("Mise à jour terminée ({$updatedCount} édition(s)).");
        }
    }
}
