# Deployment na Vercel s Firebase

## 🚀 **KROKY PRO DEPLOYMENT:**

### **1. Připravte Firebase konfiguraci:**
- Otevřete `firebase-config.js`
- Nahraďte placeholder hodnoty skutečnými Firebase credentials:
  ```javascript
  const firebaseConfig = {
      apiKey: "VAŠE_SKUTEČNÁ_API_KEY",
      authDomain: "raj-mazlicku.firebaseapp.com",
      projectId: "raj-mazlicku",
      storageBucket: "raj-mazlicku.firebasestorage.app",
      messagingSenderId: "VAŠE_SKUTEČNÉ_ID",
      appId: "VAŠE_SKUTEČNÉ_APP_ID"
  };
  ```

### **2. Nahrajte na Vercel:**
```bash
# Instalace Vercel CLI
npm i -g vercel

# Login do Vercel
vercel login

# Deployment
vercel --prod
```

### **3. Nebo použijte GitHub:**
- Nahrajte kód na GitHub
- Propojte s Vercel
- Vercel automaticky deployne při push

## 🔧 **VERCEL KONFIGURACE:**

### **vercel.json:**
- **Routes** - mapování URL bez .html přípon
- **Builds** - statické HTML + PHP soubory
- **Headers** - cache a CORS nastavení

### **firebase-config.js:**
- **Error handling** pro Vercel
- **Automatická detekce** localhost vs. produkce
- **Fallback** při chybách

## 📱 **URL STRUKTURA NA VERCEL:**

- **`/chodov`** → `chodov.html`
- **`/cheb`** → `cheb.html`
- **`/karlovy-vary`** → `karlovy-vary.html`
- **`/aktuality`** → `aktuality.html`
- **`/akvaterachodov`** → `stranka/akvaterachodov.html`
- **`/akvateracheb`** → `stranka/akvateracheb.html`

## 🔥 **FIREBASE NA VERCEL:**

### **Povolené domény:**
- Přidejte vaši Vercel doménu do Firebase Console
- **Authorized domains** → `your-app.vercel.app`

### **CORS nastavení:**
- Firebase automaticky povolí Vercel domény
- Žádné další CORS konfigurace nejsou potřeba

## 🚨 **ŘEŠENÍ PROBLÉMŮ:**

### **Firebase se nenačte:**
1. Zkontrolujte `firebase-config.js`
2. Ověřte Firebase credentials
3. Zkontrolujte Authorized domains

### **URL nefungují:**
1. Ověřte `vercel.json` routes
2. Zkontrolujte build logy
3. Restartujte deployment

### **Data se nenačítají:**
1. Ověřte Firestore pravidla
2. Zkontrolujte console chyby
3. Testujte Firebase připojení

## ✅ **TESTOVÁNÍ:**

### **Lokálně:**
```bash
vercel dev
```

### **Na Vercel:**
- Otevřete vaši Vercel doménu
- Testujte všechny URL
- Zkontrolujte Firebase data

## 📞 **PODPORA:**

- **Vercel Docs**: https://vercel.com/docs
- **Firebase Docs**: https://firebase.google.com/docs
- **Console chyby**: F12 → Console
