# Ráj mazlíčků - Webová stránka

## Nastavení email konfigurace

### 1. Gmail App Password
Pro odesílání emailů z formuláře registrace do smečky je potřeba nastavit Gmail App Password:

1. **Povolte 2FA** na vašem Google účtu
2. **Vygenerujte App Password:**
   - Jděte na [Google Account Security](https://myaccount.google.com/security)
   - Najděte "App passwords" (Hesla aplikací)
   - Vyberte "Mail" a vygenerujte nové heslo

### 2. Konfigurace
1. **Zkopírujte `config.example.js` jako `config.js`**
2. **Upravte `config.js`:**
   ```javascript
   const config = {
       gmail: {
           email: 'vas-email@gmail.com',           // Váš Gmail účet
           appPassword: 'vase-app-heslo'          // Vygenerované app heslo
       },
       // ... zbytek konfigurace
   };
   ```

### 3. Bezpečnost
- **NEUVEŘEJŇUJTE** `config.js` v repozitáři
- `config.js` je již v `.gitignore`
- Používejte pouze `config.example.js` jako šablonu

### 4. Testování
Po nastavení můžete otestovat odesílání emailů:
1. Otevřete `registrace-smecka.html`
2. Vyplňte formulář
3. Odešlete registraci
4. Zkontrolujte email na vybrané pobočce

## Struktura projektu
```
├── index.html                 # Hlavní stránka
├── registrace-smecka.html    # Registrace do smečky
├── aktuality.html            # Všechny aktuality
├── config.js                 # Email konfigurace (NEUVEŘEJŇOVAT)
├── config.example.js         # Vzorová konfigurace
├── .gitignore               # Git ignore soubor
└── stranka/                 # Podstránky poboček
    ├── akvaterachodov.html
    ├── akvateracheb.html
    ├── karlovy-vary.html
    ├── chodov-pobocka.html
    └── cheb-pobocka.html
```

## Poznámky
- Formulář automaticky odešle email na vybranou pobočku
- Všechny email adresy jsou konfigurovatelné v `config.js`
- Pro produkční nasazení zvažte použití profesionálního email service
