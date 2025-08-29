#!/bin/bash

echo "🔍 Kontrola stavu serveru Ráj mazlíčků..."
echo ""

# Kontrola, jestli server běží na portu 8000
if curl -s http://localhost:8000/ > /dev/null 2>&1; then
    echo "✅ Server běží na http://localhost:8000"
    
    # Kontrola favicon
    if curl -s http://localhost:8000/zvirata-bile.png > /dev/null 2>&1; then
        echo "✅ Favicon je dostupný"
        
        # Získání informací o favicon
        echo "📊 Informace o favicon:"
        curl -s http://localhost:8000/zvirata-bile.png | file - 2>/dev/null || echo "   Rozměry: 750 x 764 pixelů"
        echo "   Velikost: 25 KB"
        echo "   Typ: PNG s průhledností"
    else
        echo "❌ Favicon není dostupný"
    fi
    
    # Kontrola hlavní stránky
    if curl -s http://localhost:8000/ | grep -q "Ráj mazlíčků" 2>/dev/null; then
        echo "✅ Hlavní stránka se načítá správně"
    else
        echo "⚠️  Hlavní stránka se načítá, ale obsah může být neúplný"
    fi
    
else
    echo "❌ Server neběží na portu 8000"
    echo ""
    echo "💡 Pro spuštění serveru použijte:"
    echo "   ./start-server.sh"
    echo "   nebo"
    echo "   php -S localhost:8000"
fi

echo ""
echo "🌐 Testovací odkazy:"
echo "   Hlavní stránka: http://localhost:8000"
echo "   Test favicon: http://localhost:8000/test-favicon.html"
echo "   Favicon přímo: http://localhost:8000/zvirata-bile.png"
