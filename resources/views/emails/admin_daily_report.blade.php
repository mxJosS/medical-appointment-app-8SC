<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { background-color: #007bff; color: white; padding: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte Diario de Citas</h1>
        <p>Fecha: {{ $date }}</p>
    </div>
    
    <p>Hola Administrador, estas son todas las citas programadas para hoy:</p>
    
    <table>
        <thead>
            <tr>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Doctor</th>
                <th>Motivo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                    <td>{{ $appointment->patient->user->name }}</td>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->reason }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <p>Total de citas: {{ count($appointments) }}</p>
</body>
</html>
