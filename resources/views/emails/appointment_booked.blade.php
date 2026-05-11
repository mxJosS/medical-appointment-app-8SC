<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; }
        .container { padding: 20px; }
        .footer { font-size: 0.8em; color: #666; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hola, {{ $recipientName }}</h1>
        <p>Tu cita en <strong>Vitalia</strong> ha sido programada con éxito.</p>
        <p><strong>Detalles:</strong></p>
        <ul>
            <li><strong>Doctor:</strong> {{ $appointment->doctor->name }}</li>
            <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</li>
            <li><strong>Hora:</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</li>
        </ul>
        <p>Adjunto encontrarás el comprobante de tu cita en formato PDF.</p>
        <p>¡Te esperamos!</p>
    </div>
    <div class="footer">
        Este es un mensaje automático, por favor no respondas a este correo.
    </div>
</body>
</html>
