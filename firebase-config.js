// Firebase konfigurace pro Vercel hosting
// Ráj mazlíčků

// Počkáme na načtení Firebase SDK
document.addEventListener('DOMContentLoaded', function() {
    initializeFirebase();
});

// Funkce pro inicializaci Firebase
function initializeFirebase() {
    // Firebase konfigurace
    const firebaseConfig = {
        apiKey: "AIzaSyBqXqXqXqXqXqXqXqXqXqXqXqXqXqXqXq",
        authDomain: "raj-mazlicku.firebaseapp.com",
        projectId: "raj-mazlicku",
        storageBucket: "raj-mazlicku.firebasestorage.app",
        messagingSenderId: "123456789012",
        appId: "1:123456789012:web:abcdefghijklmnop"
    };

    try {
        // Kontrola, zda je Firebase SDK načten
        if (typeof firebase === 'undefined') {
            console.error('Firebase SDK není načten');
            throw new Error('Firebase SDK není dostupný');
        }

        // Inicializace Firebase
        if (!firebase.apps.length) {
            firebase.initializeApp(firebaseConfig);
            console.log('Firebase inicializován úspěšně');
        } else {
            console.log('Firebase již inicializován');
        }

        // Inicializace Firestore
        const db = firebase.firestore();
        
        // Nastavení Firestore pro Vercel
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            // Lokální vývoj - použít emulátor
            console.log('Lokální vývoj - Firebase emulátor');
        } else {
            // Produkce na Vercel - použít produkční Firebase
            console.log('Produkce na Vercel - Firebase produkce');
            
            // Nastavení pro Vercel
            db.settings({
                cacheSizeBytes: firebase.firestore.CACHE_SIZE_UNLIMITED
            });
        }

        // Export pro použití v jiných souborech
        window.firebaseApp = firebase;
        window.firebaseDB = db;
        
        console.log('Firebase konfigurace dokončena');

        // Oznámit, že Firebase je připraven
        window.dispatchEvent(new CustomEvent('firebaseReady', { detail: { db: db } }));

    } catch (error) {
        console.error('Chyba při inicializaci Firebase:', error);
        
        // Fallback - zobrazit chybu uživateli
        if (document.body) {
            const errorDiv = document.createElement('div');
            errorDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #ff4444;
                color: white;
                padding: 15px;
                border-radius: 8px;
                z-index: 10000;
                max-width: 300px;
                font-family: Arial, sans-serif;
            `;
            errorDiv.innerHTML = `
                <strong>Chyba Firebase</strong><br>
                ${error.message}<br>
                <small>Zkontrolujte konfiguraci</small>
            `;
            document.body.appendChild(errorDiv);
            
            // Skrýt po 10 sekundách
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.parentNode.removeChild(errorDiv);
                }
            }, 10000);
        }
    }
}

// Alternativní inicializace pro případ, že DOMContentLoaded už proběhl
if (document.readyState === 'loading') {
    // DOM se ještě načítá
    document.addEventListener('DOMContentLoaded', initializeFirebase);
} else {
    // DOM je už načten
    initializeFirebase();
}
