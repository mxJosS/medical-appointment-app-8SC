<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor']);
        $patientRole = Role::firstOrCreate(['name' => 'Paciente']);

        // Create Doctors
        $doc1 = User::firstOrCreate(['email' => 'luis.torres@tec.com'], [
            'name' => 'Dr. Luis Torres',
            'password' => Hash::make('password123'),
            'id_number' => 'DOC100',
            'phone' => '11111111',
            'address' => 'Centro Médico 1'
        ]);
        $doc1->assignRole($doctorRole);
        Doctor::firstOrCreate(['user_id' => $doc1->id], ['specialty' => 'Endocrinología']);

        $doc2 = User::firstOrCreate(['email' => 'juan.villagomez@tec.com'], [
            'name' => 'Dr. Juan José Villagómez',
            'password' => Hash::make('password123'),
            'id_number' => 'DOC101',
            'phone' => '22222222',
            'address' => 'Centro Médico 2'
        ]);
        $doc2->assignRole($doctorRole);
        Doctor::firstOrCreate(['user_id' => $doc2->id], ['specialty' => 'Cardiología']);

        $doc3 = User::firstOrCreate(['email' => 'maria.lopez@tec.com'], [
            'name' => 'Dra. María López',
            'password' => Hash::make('password123'),
            'id_number' => 'DOC102',
            'phone' => '33333333',
            'address' => 'Centro Médico 3'
        ]);
        $doc3->assignRole($doctorRole);
        Doctor::firstOrCreate(['user_id' => $doc3->id], ['specialty' => 'Pediatría']);

        // Create Patients
        $pat1 = User::firstOrCreate(['email' => 'berta.mota@tec.com'], [
            'name' => 'Berta Mota',
            'password' => Hash::make('password123'),
            'id_number' => 'PAT100',
            'phone' => '44444444',
            'address' => 'Calle Falsa 123'
        ]);
        $pat1->assignRole($patientRole);
        $patient1 = Patient::firstOrCreate(['user_id' => $pat1->id], [
            'blood_type_id' => 1,
            'emergency_contact_name' => 'Juan Mota',
            'emergency_contact_phone' => '55555555'
        ]);

        $pat2 = User::firstOrCreate(['email' => 'carlos.ruiz@tec.com'], [
            'name' => 'Carlos Ruiz',
            'password' => Hash::make('password123'),
            'id_number' => 'PAT101',
            'phone' => '66666666',
            'address' => 'Av Siempre Viva 742'
        ]);
        $pat2->assignRole($patientRole);
        $patient2 = Patient::firstOrCreate(['user_id' => $pat2->id], [
            'blood_type_id' => 2,
            'emergency_contact_name' => 'Ana Ruiz',
            'emergency_contact_phone' => '77777777'
        ]);

        // Create some appointments for today and tomorrow
        $today = Carbon::now()->format('Y-m-d');
        
        Appointment::firstOrCreate([
            'patient_id' => $patient1->id,
            'doctor_id' => $doc1->id,
            'date' => $today,
            'start_time' => '08:00:00'
        ], [
            'end_time' => '08:15:00',
            'duration' => 15,
            'reason' => 'Chequeo general de hormonas',
            'status' => 1
        ]);

        Appointment::firstOrCreate([
            'patient_id' => $patient2->id,
            'doctor_id' => $doc2->id,
            'date' => $today,
            'start_time' => '09:00:00'
        ], [
            'end_time' => '09:30:00',
            'duration' => 30,
            'reason' => 'Revisión de presión arterial',
            'status' => 1
        ]);

        // Citas pasadas (Historial)
        $pastDate = Carbon::now()->subDays(15)->format('Y-m-d');
        $pastApp = Appointment::firstOrCreate([
            'patient_id' => $patient2->id,
            'doctor_id' => $doc2->id,
            'date' => $pastDate,
            'start_time' => '10:00:00'
        ], [
            'end_time' => '10:30:00',
            'duration' => 30,
            'reason' => 'Dolor de pecho leve',
            'status' => 0, 
            'diagnosis' => 'Angina estable leve',
            'treatment' => 'Reposo relativo y medicación',
            'notes' => 'El paciente debe evitar esfuerzos físicos intensos.'
        ]);

        \App\Models\Prescription::firstOrCreate([
            'appointment_id' => $pastApp->id,
            'medicine_name' => 'Aspirina 100mg'
        ], [
            'dosis' => '1 pastilla',
            'frecuencia' => 'Cada 24 horas por 30 días'
        ]);
    }
}
