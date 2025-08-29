#!/bin/bash

# Skript pro ovládání serveru Ráj mazlíčků

case "$1" in
    start)
        echo "🚀 Spouštím server Ráj mazlíčků..."
        echo "Web bude dostupný na: http://localhost:8000"
        echo "Pro ukončení stiskněte Ctrl+C"
        echo ""
        php -S localhost:8000 router.php
        ;;
    stop)
        echo "🛑 Zastavuji server..."
        pkill -f "php -S localhost:8000" 2>/dev/null
        echo "Server byl zastaven."
        ;;
    status)
        ./check-server.sh
        ;;
    restart)
        echo "🔄 Restartuji server..."
        pkill -f "php -S localhost:8000" 2>/dev/null
        sleep 2
        echo "🚀 Spouštím server znovu..."
        php -S localhost:8000 router.php &
        echo "Server byl restartován."
        ;;
    *)
        echo "🎮 Ovládání serveru Ráj mazlíčků"
        echo ""
        echo "Použití: $0 {start|stop|status|restart}"
        echo ""
        echo "Příkazy:"
        echo "  start   - Spustit server"
        echo "  stop    - Zastavit server"
        echo "  status  - Zobrazit stav serveru"
        echo "  restart - Restartovat server"
        echo ""
        echo "Příklady:"
        echo "  $0 start    # Spustit server"
        echo "  $0 status   # Zkontrolovat stav"
        echo "  $0 stop     # Zastavit server"
        ;;
esac
