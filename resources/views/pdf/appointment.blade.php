<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Cita - Vitalia</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .logo { font-size: 24px; font-weight: bold; color: #007bff; }
        .content { margin-top: 30px; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; width: 30%; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">VITALIA</div>
        <p>Sistema de Gestión Médica</p>
    </div>

    <div class="content">
        <h2 style="text-align: center;">Comprobante de Cita Médica</h2>
        <table class="info-table">
            <tr>
                <td class="label">Paciente:</td>
                <td>{{ $appointment->patient->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Doctor:</td>
                <td>{{ $appointment->doctor->name }}</td>
            </tr>
            <tr>
                <td class="label">Fecha:</td>
                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Hora:</td>
                <td>{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Motivo:</td>
                <td>{{ $appointment->reason }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Este es un comprobante automático generado por Vitalia.</p>
        <p>Por favor, llegue 15 minutos antes de su cita.</p>
    </div>
</body>
</html>
