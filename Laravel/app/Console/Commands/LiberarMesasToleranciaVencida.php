<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\reserva;
use Carbon\Carbon;

#[Signature('reservas:liberar-vencidas')]
#[Description('Libera mesas y cancela reservas que excedieron la tolerancia de 15 minutos en el salón')]
class LiberarMesasToleranciaVencida extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $limite = Carbon::now('America/Lima')->subMinutes(15);

        $afectadas = reserva::where('estado', 'Pendiente')
            ->where('fecha_reserva', '<', $limite)
            ->update([
                'estado' => 'Cancelada',
                'mesa' => null,
                'notas' => 'Cancelado automáticamente por exceder la tolerancia de 15 minutos.'
            ]);

        $this->info("✅ Proceso completado: Se liberaron {$afectadas} reservas/mesas vencidas (Tolerancia > 15 min).");

        return Command::SUCCESS;
    }
}
