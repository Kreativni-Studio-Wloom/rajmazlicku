# Router pro PHP Built-in Server

## Jak spustit server s odkazy bez .html

Tento projekt používá `router.php` soubor, který umožňuje používat odkazy bez `.html` přípony na PHP built-in serveru.

### Spuštění serveru:

```bash
php -S localhost:8000 router.php
```

**DŮLEŽITÉ:** Musíte použít `router.php` jako router, jinak odkazy bez .html nebudou fungovat!

### Dostupné URL bez .html:

- **Hlavní stránka:** `/`
- **VOP:** `/vop`
- **GDPR:** `/gdpr`
- **Podmínky smečky:** `/podminky-smecka`
- **Registrace:** `/registrace-smecka`
- **Pobočky:** `/karlovy-vary`, `/chodov-pobocka`, `/cheb-pobocka`
- **Trhy:** `/akvaterachodov`, `/akvateracheb`
- **Dashboard:** `/dashboard`
- **Blog:** `/blog`
- **Aktuality:** `/aktuality`

### Jak to funguje:

1. `router.php` zachytává všechny požadavky
2. Mapuje URL bez .html na odpovídající .html soubory
3. Zobrazuje správný obsah nebo 404 chybu

### Poznámky:

- Všechny odkazy na stránkách jsou nyní bez .html
- Navigace funguje správně mezi všemi stránkami
- Server musí být spuštěn s `router.php`
- Na produkčním serveru můžete použít .htaccess místo router.php

### Testování:

Otestujte všechny odkazy:
- Klikněte na "Registrovat se" -> mělo by jít na `/registrace-smecka`
- Navigace mezi stránkami -> mělo by fungovat bez .html
- Všechny tlačítka -> měly by odkazovat na čisté URL
