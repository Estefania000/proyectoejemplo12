# ============================================
# Script de monitoreo de disponibilidad
# Proyecto: Laravel/PHP
# Autor: Martínez Rojas Estefania
# ============================================

$url       = "http://localhost:8000/up"
$intervalo = 60    # segundos entre revisiones
$timeout   = 10    # segundos máximos de espera
$logFile   = "storage/logs/monitoreo_disponibilidad.log"

Write-Host "=== Monitoreo iniciado ===" -ForegroundColor Green
Write-Host "URL: $url"
Write-Host "Intervalo: $intervalo s | Timeout: $timeout s"
Write-Host "Log: $logFile"
Write-Host "Presiona Ctrl+C para detener."
Write-Host ""

while ($true) {
    $fecha = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    try {
        $inicio = Get-Date
        $response = Invoke-WebRequest -Uri $url -TimeoutSec $timeout -UseBasicParsing
        $fin = Get-Date
        $duracion = [math]::Round(($fin - $inicio).TotalMilliseconds, 2)
        $estado = "UP ($($response.StatusCode)) - ${duracion}ms"
    } catch {
        $estado = "DOWN - Error: $($_.Exception.Message)"
    }

    $linea = "$fecha | $estado"
    Add-Content -Path $logFile -Value $linea
    Write-Host $linea
    Start-Sleep -Seconds $intervalo
}