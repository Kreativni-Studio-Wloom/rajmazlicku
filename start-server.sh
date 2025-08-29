#!/bin/bash

# Startovací skript pro Ráj mazlíčků web
echo "Spouštím PHP server pro Ráj mazlíčků..."
echo "Web bude dostupný na: http://localhost:8000"
echo "Pro ukončení stiskněte Ctrl+C"
echo ""

# Spustit PHP server z aktuálního adresáře s routerem
php -S localhost:8000 router.php

echo ""
echo "Server byl ukončen."
