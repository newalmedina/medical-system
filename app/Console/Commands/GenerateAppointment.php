<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Center;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class GenerateAppointment extends Command
{
    protected $signature = 'appointment:generate';
    protected $description = 'Genera varias citas médicas de forma aleatoria';

    public function handle()
    {
        $faker = Faker::create();

        if (Carbon::today()->isSunday()) {
            $this->info("Hoy es domingo, no se generarán citas médicas.");
            return;
        }

        $numAppointments = $faker->numberBetween(0, 10);

        for ($i = 0; $i < $numAppointments; $i++) {
            $user = User::select("users.*")->inRandomOrder()->patients()->active()->first();
            if (!$user) {
                $this->error("No se encontró un usuario paciente activo.");
                continue;
            }

            $center = Center::inRandomOrder()->first();
            $service = Service::inRandomOrder()->first();
            if (!$center || !$service) {
                $this->error("No se encontraron centros o servicios disponibles.");
                continue;
            }

            $start_at = Carbon::today()->addMinutes($faker->numberBetween(0, 1435));
            $end_at = $start_at->copy()->addMinutes(15);

            $color = "#6c757d";
            $finish_at = null;
            $paid_at = $faker->boolean ? Carbon::now() : null;

            if ($paid_at) {
                $color = "#ffc107";
                $finish_at = $faker->boolean ? Carbon::now() : null;
                if ($finish_at) {
                    $color = "#28a745";
                }
            }

            $appointment = Appointment::create([
                "title" => "Cita médica",
                "user_id" => $user->id,
                "center_id" => $center->id,
                "created_by" => 1,
                "doctor_id" => 1,
                "service_id" => $service->id,
                "start_at" => $start_at,
                "end_at" => $end_at,
                "price" => $service->price,
                "total" => $service->price,
                "color" => $color,
                "comment" => $faker->paragraph(),
                "paid_at" => $paid_at,
                "finish_at" => $finish_at,
            ]);
        }
        $this->info('Creando citas para el dia ' . Carbon::now()->format("d-m-Y H:i"));
    }
}
