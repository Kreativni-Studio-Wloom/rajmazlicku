// Firebase konfigurace pro Ráj mazlíčků blog
const firebaseConfig = {
    apiKey: "AIzaSyAv5pS3oBq5lGes6HL5YmYB5Wpxroc8Wi4",
    authDomain: "raj-mazlicku.firebaseapp.com",
    projectId: "raj-mazlicku",
    storageBucket: "raj-mazlicku.firebasestorage.app",
    messagingSenderId: "578253400256",
    appId: "1:578253400256:web:ff32e700c59cc78c1c6525",
    measurementId: "G-838QHXJWK7"
};

// Přihlašovací údaje pro dashboard
const dashboardCredentials = {
    email: "info@rajmazlicku.eu",
    password: "Acer2016"
};

// Inicializace Firebase
firebase.initializeApp(firebaseConfig);

// Inicializace služeb
const auth = firebase.auth();
const db = firebase.firestore();
const storage = firebase.storage();

// Export pro použití v jiných souborech
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { firebaseConfig, dashboardCredentials };
}
