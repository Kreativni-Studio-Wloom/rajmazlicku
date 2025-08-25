// Ukázkový článek pro demonstraci blog systému
// Tento soubor slouží k přidání ukázkového článku do lokálního úložiště

const demoPost = {
    id: "demo-post-1",
    title: "Vítejte v našem novém blogu!",
    category: "Novinky",
    tags: ["blog", "novinky", "raj mazlíčků"],
    content: `Vítejte v našem novém blogu! Jsme nadšeni, že vám můžeme přinášet nejnovější informace o našich aktivitách, událostech a novinkách ze světa mazlíčků.

Tento článek slouží jako ukázka funkčnosti našeho nového blog systému. Můžete zde najít:

• Informace o našich AkvaTera trzích
• Novinky z našich poboček
• Užitečné tipy pro chovatele
• Zajímavosti ze světa zvířat

Budeme pravidelně přidávat nové články, takže se máte na co těšit! Sledujte naši sekci Aktuality pro nejnovější informace.

Těšíme se na vaše návštěvy a komentáře!`,
    imageUrl: "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjI1MCIgdmlld0JveD0iMCAwIDQwMCAyNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMjUwIiBmaWxsPSIjMDBhNzllIi8+Cjx0ZXh0IHg9IjIwMCIgeT0iMTI1IiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMjQiIGZpbGw9IndoaXRlIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+Vml0ZWp0ZSB2IG5hxaFpbSBibG9ndSE8L3RleHQ+Cjx0ZXh0IHg9IjIwMCIgeT0iMTU1IiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTYiIGZpbGw9IndoaXRlIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+8J+OjSDwn46P8J+OjTwvdGV4dD4KPC9zdmc+",
    timestamp: new Date().toISOString(),
    author: "info@rajmazlicku.eu",
    order: 1
};

// Funkce pro přidání ukázkového článku
async function addDemoPost() {
    try {
        if (typeof firebase !== 'undefined' && firebase.firestore) {
            const db = firebase.firestore();
            const demoDoc = await db.collection('posts').doc(demoPost.id).get();
            
            if (!demoDoc.exists) {
                await db.collection('posts').doc(demoPost.id).set(demoPost);
                console.log('Ukázkový článek byl úspěšně přidán do Firebase!');
                alert('Ukázkový článek byl úspěšně přidán do Firebase! Nyní můžete vidět, jak vypadá sekce Aktuality na hlavní stránce.');
            } else {
                console.log('Ukázkový článek už existuje v Firebase.');
                alert('Ukázkový článek už existuje v Firebase.');
            }
        } else {
            console.log('Firebase není dostupný.');
            alert('Firebase není dostupný. Ukázkový článek nebyl přidán.');
        }
    } catch (error) {
        console.error('Chyba při přidávání ukázkového článku:', error);
        alert('Chyba při přidávání ukázkového článku: ' + error.message);
    }
}

// Funkce pro odstranění ukázkového článku
async function removeDemoPost() {
    try {
        if (typeof firebase !== 'undefined' && firebase.firestore) {
            const db = firebase.firestore();
            await db.collection('posts').doc(demoPost.id).delete();
            console.log('Ukázkový článek byl odstraněn z Firebase!');
            alert('Ukázkový článek byl odstraněn z Firebase!');
        } else {
            console.log('Firebase není dostupný.');
            alert('Firebase není dostupný. Ukázkový článek nebyl odstraněn.');
        }
    } catch (error) {
        console.error('Chyba při odstraňování ukázkového článku:', error);
        alert('Chyba při odstraňování ukázkového článku: ' + error.message);
    }
}

// Funkce pro definitivní odstranění demo postu (vypne automatické přidávání)
async function permanentlyRemoveDemoPost() {
    try {
        if (typeof firebase !== 'undefined' && firebase.firestore) {
            const db = firebase.firestore();
            
            // Odstranění demo postu
            await db.collection('posts').doc(demoPost.id).delete();
            console.log('Demo post byl odstraněn z Firebase!');
            
            // Přidání flagu, že demo post už není potřeba
            await db.collection('system').doc('demo-post-status').set({
                disabled: true,
                disabledAt: new Date(),
                reason: 'Manuálně vypnuto uživatelem'
            });
            
            alert('Demo post byl definitivně odstraněn a už se nebude automaticky přidávat!');
        } else {
            console.log('Firebase není dostupný.');
            alert('Firebase není dostupný. Demo post nebyl odstraněn.');
        }
    } catch (error) {
        console.error('Chyba při definitivním odstranění demo postu:', error);
        alert('Chyba při definitivním odstranění demo postu: ' + error.message);
    }
}

        // Kontrola, zda je demo post vypnutý
        if (typeof window !== 'undefined') {
            window.addEventListener('DOMContentLoaded', async () => {
                // Kontrola, zda je Firebase dostupný
                if (typeof firebase !== 'undefined' && firebase.firestore) {
                    try {
                        const db = firebase.firestore();
                        
                        // Kontrola, zda je demo post vypnutý
                        const demoStatusDoc = await db.collection('system').doc('demo-post-status').get();
                        
                        if (demoStatusDoc.exists && demoStatusDoc.data().disabled) {
                            console.log('Demo post je trvale vypnutý - už se nebude automaticky přidávat.');
                            return;
                        }
                        
                        // Pokud není vypnutý, zkontrolujeme, zda existuje
                        const demoDoc = await db.collection('posts').doc(demoPost.id).get();
                        
                        if (!demoDoc.exists) {
                            console.log('Demo post neexistuje a automatické přidávání je vypnuto.');
                        } else {
                            console.log('Demo post existuje, ale automatické přidávání je vypnuto.');
                        }
                    } catch (error) {
                        console.error('Chyba při kontrole demo postu:', error);
                    }
                } else {
                    console.log('Firebase není dostupný, demo post kontrola nebyla provedena.');
                }
            });
        }
        
        console.log('Demo post automatické přidávání je vypnuto.');

// Export pro Node.js
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { demoPost, addDemoPost, removeDemoPost };
}
