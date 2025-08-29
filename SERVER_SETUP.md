# Nastavení serveru pro Ráj mazlíčků

## Rychlé spuštění

### Metoda 1: Pomocí startovacího skriptu
```bash
./start-server.sh
```

### Metoda 2: Přímé spuštění PHP serveru s routerem
```bash
php -S localhost:8000 router.php
```

## Přístup k webu

Po spuštění serveru bude web dostupný na:
- **Hlavní stránka:** http://localhost:8000
- **Favicon:** http://localhost:8000/zvirata-bile.png

## Proč PHP server?

Apache server má DocumentRoot nastaven na `/Library/WebServer/Documents`, ale náš projekt je v `/Users/adam/Desktop/files/rm2 copy`. PHP built-in server řeší tento problém tím, že běží přímo z našeho adresáře.

## Ukončení serveru

Stiskněte `Ctrl+C` v terminálu, kde běží server.

## Poznámky

- Favicon se nyní zobrazuje správně
- Všechny statické soubory (CSS, JS, obrázky) jsou dostupné
- PHP skripty fungují normálně
- Server automaticky zpracovává .htaccess pravidla
