#!/bin/bash
# ============================================
# Script de monitoreo de disponibilidad
# Proyecto: Laravel/PHP
# Autor: Martínez Rojas Estefania
# ============================================

URL="http://localhost:8000/up"
INTERVALO=60
TIMEOUT=10
LOG_FILE="storage/logs/monitoreo_disponibilidad.log"

echo "=== Monitoreo iniciado ==="
echo "URL: $URL"
echo "Intervalo: ${INTERVALO}s | Timeout: ${TIMEOUT}s"
echo "Log: $LOG_FILE"
echo "Presiona Ctrl+C para detener."
echo ""

while true; do
    FECHA=$(date +"%Y-%m-%d %H:%M:%S")
    
    # Hacemos la petición y capturamos el código HTTP y el tiempo de respuesta
    RESULTADO=$(curl -o /dev/null -s -w "%{http_code} - %{time_total}s" --max-time $TIMEOUT $URL)

    if [ -z "$RESULTADO" ] || [ "$RESULTADO" == "000 - 0.000000s" ]; then
        ESTADO="DOWN - Sin respuesta o Timeout"
    else
        ESTADO="UP ($RESULTADO)"
    fi

    LINEA="$FECHA | $ESTADO"
    
    # Guardamos en el log y mostramos en pantalla
    echo "$LINEA" >> "$LOG_FILE"
    echo "$LINEA"
    
    # Esperamos el intervalo definido
    sleep $INTERVALO
done