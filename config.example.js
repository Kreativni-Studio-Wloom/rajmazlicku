// Vzorový konfigurační soubor - zkopírujte jako config.js a upravte
const config = {
    // Gmail SMTP Configuration
    gmail: {
        email: 'your-email@gmail.com',        // Nahraďte svým Gmail účtem
        appPassword: 'your-app-password'      // Nahraďte svým app heslem z Gmail
    },
    
    // Email adresy poboček
    branchEmails: {
        'karlovy-vary': 'karlovy.vary@rajmazlicku.eu',
        'chodov': 'chodov@rajmazlicku.eu',
        'cheb': 'cheb@rajmazlicku.eu'
    }
};

// Export pro použití v jiných souborech
if (typeof module !== 'undefined' && module.exports) {
    module.exports = config;
} else {
    // Pro použití v prohlížeči
    window.config = config;
}
