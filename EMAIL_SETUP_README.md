# Nastavení Email Systému - Ráj mazlíčků

## 📧 Konfigurace SMTP Seznam.cz

### **Základní informace:**
- **SMTP Server:** smtp.seznam.cz
- **Port:** 465 (šifrované spojení SSL/TLS)
- **Autentifikace:** Povinná
- **Email:** info@rajmazlicku.eu
- **Heslo:** Acer2016

## 🚀 Instalace a nastavení

### **1. Základní verze (PHP mail() funkce)**
- Použijte soubor `send-email.php`
- Funguje na většině hostingů s PHP
- **Výhody:** Jednoduché, nepotřebuje další knihovny
- **Nevýhody:** Méně spolehlivé, omezené možnosti

### **2. Pokročilá verze (PHPMailer)**
- Použijte soubor `send-email-advanced.php`
- Vyžaduje instalaci PHPMailer
- **Výhody:** Spolehlivé, pokročilé možnosti, lepší error handling
- **Nevýhody:** Potřebuje Composer a PHPMailer

## 📋 Instalace PHPMailer (volitelné)

### **Přes Composer (doporučeno):**
```bash
composer require phpmailer/phpmailer
```

### **Manuální instalace:**
1. Stáhněte PHPMailer z GitHub
2. Umístěte soubory do složky `vendor/phpmailer/phpmailer/`
3. Upravte autoload v `send-email-advanced.php`

## 🔒 Bezpečnost

### **Ochrana citlivých údajů:**
- ✅ Hesla a emaily jsou skryté v PHP souborech
- ✅ `.htaccess` blokuje přístup k citlivým souborům
- ✅ Pouze POST požadavky jsou povoleny na email skripty
- ✅ Bezpečnostní hlavičky jsou nastaveny

### **Soubory k ochraně:**
- `config.js` - blokován přístup
- `send-email*.php` - pouze POST požadavky
- `.htaccess` - blokován přístup
- `vendor/` složka - blokována

## 🧪 Testování

### **1. Otestujte formulář:**
- Vyplňte registrační formulář
- Odešlete data
- Zkontrolujte, zda dorazil email

### **2. Zkontrolujte logy:**
- PHP error log
- Server error log
- Email log (pokud je dostupný)

### **3. Debug módu:**
- V `send-email-advanced.php` nastavte `$mail->SMTPDebug = 2;`
- Uvidíte detailní SMTP komunikaci

## 🐛 Řešení problémů

### **Email se neodešle:**
1. Zkontrolujte SMTP nastavení
2. Ověřte heslo a email
3. Zkontrolujte firewall nastavení
4. Ověřte PHP mail() funkci

### **Chyba SMTP:**
1. Zkontrolujte port 465
2. Ověřte SSL/TLS nastavení
3. Zkontrolujte autentifikaci

### **Formulář nefunguje:**
1. Zkontrolujte JavaScript konzoli
2. Ověřte PHP error log
3. Zkontrolujte .htaccess nastavení

## 📱 Integrace s formulářem

### **JavaScript změny:**
- Formulář nyní odesílá data na `send-email.php`
- Používá fetch API pro AJAX požadavky
- Zpracovává JSON odpovědi
- Zobrazuje úspěch/chybu uživateli

### **PHP zpracování:**
- Validuje vstupní data
- Vytváří HTML email
- Odesílá přes SMTP
- Vrací JSON odpověď

## 🌐 Hosting požadavky

### **Minimální požadavky:**
- PHP 7.4+
- Povolené mail() funkce
- SSL certifikát (pro port 465)

### **Doporučené:**
- PHP 8.0+
- PHPMailer knihovna
- SMTP podpora
- Error logging

## 📞 Podpora

### **Kontakt:**
- **Email:** info@rajmazlicku.eu
- **Web:** https://rajmazlicku.eu

### **Dokumentace:**
- Seznam.cz SMTP: https://napoveda.seznam.cz/cz/email/nastaveni-emailoveho-klienta/
- PHPMailer: https://github.com/PHPMailer/PHPMailer

---

**Poznámka:** Všechny citlivé údaje jsou bezpečně skryté a chráněné. Nikdo nemůže vidět hesla nebo přístupové údaje z veřejně dostupných souborů.
