# Blog Systém - Ráj mazlíčků

## Přehled

Blog systém je plně integrován s Firebase Firestore databází a automaticky importuje články do sekce "Aktuality" na hlavní stránce.

## Funkce

### ✅ Automatický import z Firestore
- Blog články se načítají automaticky z kolekce `posts` v Firestore
- Automatické obnovování každých 5 minut
- Inteligentní zpracování chyb a fallback stavy

### ✅ Správa obsahu
- Články se řadí podle pole `order` a `timestamp`
- Podporuje kategorie, tagy, obrázky a obsah
- Automatické generování excerpt (zkráceného textu)

### ✅ Optimalizace výkonu
- Lazy loading obrázků s fallback obrázky
- Automatické zastavení načítání při skrytí stránky
- Měření času načítání pro debugging

## Struktura dat v Firestore

### Kolekce: `posts`
```javascript
{
  id: "unique-id",
  title: "Název článku",
  content: "Obsah článku (HTML nebo plain text)",
  category: "Kategorie",
  tags: ["tag1", "tag2", "tag3"],
  imageUrl: "URL obrázku",
  timestamp: Timestamp,
  order: 1,
  author: "email@example.com"
}
```

### Povinná pole
- `title` - Název článku
- `content` - Obsah článku
- `id` - Unikátní identifikátor (automaticky generován)

### Volitelná pole
- `category` - Kategorie článku
- `tags` - Pole tagů
- `imageUrl` - URL obrázku
- `timestamp` - Čas vytvoření
- `order` - Pořadí zobrazení
- `author` - Autor článku

## Implementace

### Hlavní funkce

#### `loadAktuality()`
- Asynchronně načítá články z Firestore
- Zobrazuje loading stav
- Zpracovává chyby a zobrazuje uživatelsky přívětivé zprávy
- Automaticky filtruje neplatné články

#### `openBlogPost(postId)`
- Otevírá blog článek v novém okně
- Validuje ID článku před otevřením

### Automatické obnovování
- **První načtení**: 500ms po načtení stránky
- **Automatické obnovování**: Každých 5 minut
- **Optimalizace**: Zastavení při skrytí stránky

### Zpracování chyb
- **permission-denied**: Problém s oprávněními
- **unavailable**: Databáze nedostupná
- **deadline-exceeded**: Vypršel časový limit
- **not-found**: Kolekce nenalezena
- **invalid-argument**: Neplatný dotaz

## Konfigurace

### Firebase
- Projekt: `raj-mazlicku`
- Kolekce: `posts`
- Autentifikace: Veřejné čtení

### Dashboard
- URL: `dashboard.html`
- Přihlášení: `info@rajmazlicku.eu`
- Heslo: `Acer2016`

### Nástroje pro správu
- **test-firebase.html** - Diagnostika Firebase připojení
- **remove-demo-post.html** - Definitivní odstranění demo postu

## Použití

### Pro uživatele
1. Navštivte hlavní stránku
2. Sekce "Aktuality" se automaticky načte
3. Klikněte na článek pro zobrazení detailu
4. Články se automaticky obnovují

### Pro administrátory
1. Přihlaste se do dashboardu
2. Přidejte nový článek s požadovanými poli
3. Článek se automaticky zobrazí v aktualitách
4. Změny se projeví do 5 minut

## Technické detaily

### Seřazení článků
1. **Primární**: Podle pole `order` (vzestupně)
2. **Sekundární**: Podle `timestamp` (sestupně)

### Filtrování
- Automatické odstranění HTML tagů z excerpt
- Validace všech vstupních dat
- Fallback hodnoty pro chybějící data

### Performance
- Lazy loading obrázků
- Debounced načítání
- Optimalizace pro mobilní zařízení

## Troubleshooting

### Články se nezobrazují
1. Zkontrolujte Firebase konfiguraci
2. Ověřte existenci kolekce `posts`
3. Zkontrolujte console pro chybové zprávy
4. Použijte testovací stránku `test-firebase.html`

### Pomalé načítání
1. Zkontrolujte velikost obrázků
2. Ověřte síťové připojení
3. Zkontrolujte Firestore pravidla

### Chyby při načítání
1. Zkontrolujte console pro detailní chyby
2. Ověřte oprávnění k databázi
3. Zkuste tlačítko "Zkusit znovu"
4. Použijte testovací stránku pro diagnostiku

### Nejčastější chyby a řešení

#### "Firebase není dostupný"
- Zkontrolujte připojení k internetu
- Ověřte, zda se načetly Firebase SDK skripty
- Zkontrolujte, zda není blokován přístup k Firebase doménám

#### "Firestore služba nenalezena"
- Ověřte, zda se načetl `firebase-firestore-compat.js`
- Zkontrolujte pořadí načítání skriptů
- Restartujte stránku

#### "Problém s oprávněními"
- Kolekce `posts` není veřejně čitelná
- Zkontrolujte Firestore pravidla zabezpečení
- Ověřte, zda je povoleno veřejné čtení

#### "Kolekce posts neexistuje"
- Kolekce nebyla ještě vytvořena
- Použijte dashboard pro přidání prvního článku
- Zkontrolujte název kolekce (musí být přesně "posts")

### Testovací nástroje

#### test-firebase.html
- Kompletní diagnostika Firebase připojení
- Test Firestore služby
- Ověření kolekce posts
- Detailní logování chyb

#### Console debugging
- Otevřete Developer Tools (F12)
- Přejděte na záložku Console
- Hledejte chybové zprávy a logy
- Čas načítání a detailní informace o chybách

## Demo Post

### Co je demo post?
Demo post "Vítejte v našem novém blogu!" byl automaticky vytvářen pro demonstraci funkčnosti blog systému.

### Problém s automatickým přidáváním
Demo post se automaticky přidával při každém načtení stránky, což způsobovalo problémy při jeho manuálním odstranění.

### Řešení
1. **Automatické přidávání je vypnuto** - demo post se už nebude automaticky vytvářet
2. **Nástroj pro definitivní odstranění** - `remove-demo-post.html`
3. **Trvalé vypnutí** - demo post lze trvale vypnout pomocí flagu v kolekci `system`

### Jak definitivně odstranit demo post
1. Otevřete `remove-demo-post.html`
2. Klikněte na "🗑️ DEFINITIVNĚ ODSTRANIT"
3. Demo post bude odstraněn a trvale vypnut
4. Už se nebude automaticky přidávat

## Budoucí vylepšení

- [ ] Cachování článků v localStorage
- [ ] Offline podpora
- [ ] Pokročilé filtrování a vyhledávání
- [ ] Pagination pro velké množství článků
- [ ] Real-time updates pomocí Firestore listeners
- [ ] Komprese obrázků
- [ ] SEO optimalizace

## Řešení chyb

### Krok 1: Diagnostika
1. Otevřete `test-firebase.html` v prohlížeči
2. Spusťte automatické testy
3. Zkontrolujte výsledky a logy

### Krok 2: Console debugging
1. Otevřete Developer Tools (F12)
2. Přejděte na záložku Console
3. Obnovte stránku a sledujte logy
4. Hledejte chybové zprávy

### Krok 3: Kontrola Firebase
1. Ověřte připojení k internetu
2. Zkontrolujte, zda se načetly Firebase SDK
3. Ověřte Firebase konfiguraci

### Krok 4: Kontrola databáze
1. Zkontrolujte existenci kolekce `posts`
2. Ověřte Firestore pravidla zabezpečení
3. Zkuste přidat testovací článek přes dashboard

### Krok 5: Kontakt
Pro technickou podporu kontaktujte: `info@rajmazlicku.eu`
