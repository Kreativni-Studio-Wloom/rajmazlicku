<?php
// Router pro PHP vestavěný server
// Tento soubor řeší problémy s .htaccess na PHP serveru

$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Odstranit trailing slash
$path = rtrim($path, '/');

// Favicon aliasy - přesměrovat na zvirata-bile.png
$favicon_aliases = [
    '/favicon.ico',
    '/favicon.png',
    '/apple-touch-icon.png',
    '/apple-touch-icon-precomposed.png'
];

if (in_array($path, $favicon_aliases)) {
    $favicon_path = __DIR__ . '/zvirata-bile.png';
    if (file_exists($favicon_path)) {
        header("Content-Type: image/png");
        header("Cache-Control: public, max-age=31536000");
        header("Expires: Thu, 31 Dec 2025 23:59:59 GMT");
        readfile($favicon_path);
        exit;
    }
}

// Nechat statické soubory projít bez zpracování
$extension = pathinfo($path, PATHINFO_EXTENSION);
$static_extensions = ['png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'css', 'js', 'woff', 'woff2', 'ttf', 'eot'];
if (in_array(strtolower($extension), $static_extensions)) {
    $file_path = __DIR__ . $path;
    
    // Debug informace pro favicon
    if ($path === '/zvirata-bile.png') {
        error_log("Favicon request: $path -> $file_path (exists: " . (file_exists($file_path) ? 'yes' : 'no') . ")");
    }
    
    if (file_exists($file_path)) {
        $content_types = [
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject'
        ];
        
        $content_type = $content_types[strtolower($extension)] ?? 'application/octet-stream';
        header("Content-Type: $content_type");
        header("Cache-Control: public, max-age=31536000");
        header("Expires: Thu, 31 Dec 2025 23:59:59 GMT");
        
        // Debug informace pro favicon
        if ($path === '/zvirata-bile.png') {
            error_log("Serving favicon: $file_path (size: " . filesize($file_path) . " bytes)");
        }
        
        readfile($file_path);
        exit;
    } else {
        // Debug informace pro favicon
        if ($path === '/zvirata-bile.png') {
            error_log("Favicon not found: $file_path");
        }
    }
}

// Pokud je prázdná cesta, přesměrovat na index.html
if (empty($path) || $path === '/') {
    $path = '/index.html';
}

// Kontrola pro /aktuality/{id} - jednotlivé články
if (preg_match('/^\/aktuality\/(.+)$/', $path, $matches)) {
    $post_id = $matches[1];
    
    // Vytvořit dynamickou stránku článku
    $html_content = generatePostPage($post_id);
    if ($html_content) {
        header("Content-Type: text/html; charset=UTF-8");
        echo $html_content;
        exit;
    }
}

// Mapování specifických URL na soubory (pouze pro složky a speciální případy)
$url_mapping = [
    '/akvaterachodov' => '/stranka/akvaterachodov.html',
    '/akvateracheb' => '/stranka/akvateracheb.html'
];

// Kontrola, zda existuje přímé mapování
if (isset($url_mapping[$path])) {
    $file_path = __DIR__ . $url_mapping[$path];
    if (file_exists($file_path)) {
        $content = file_get_contents($file_path);
        $content_type = 'text/html';
        
        // Nastavit správný Content-Type
        if (pathinfo($file_path, PATHINFO_EXTENSION) === 'css') {
            $content_type = 'text/css';
        } elseif (pathinfo($file_path, PATHINFO_EXTENSION) === 'js') {
            $content_type = 'application/javascript';
        }
        
        header("Content-Type: $content_type");
        echo $content;
        exit;
    }
}

// Zkusit najít soubor s .html příponou
$html_file = __DIR__ . $path . '.html';
if (file_exists($html_file)) {
    $content = file_get_contents($html_file);
    header("Content-Type: text/html");
    echo $content;
    exit;
}

// Zkusit najít soubor bez přípony
$file = __DIR__ . $path;
if (file_exists($file)) {
    $content = file_get_contents($file);
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    
    $content_types = [
        'html' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml'
    ];
    
    $content_type = $content_types[$extension] ?? 'text/plain';
    header("Content-Type: $content_type");
    echo $content;
    exit;
}

// Pokud soubor neexistuje, zkusit index.html ve složce
$index_in_dir = __DIR__ . $path . '/index.html';
if (file_exists($index_in_dir)) {
    $content = file_get_contents($index_in_dir);
    header("Content-Type: text/html");
    echo $content;
    exit;
}

// Pokud nic nenajdeme, zobrazit moderní 404 stránku
http_response_code(404);
echo generateErrorPage($path);
exit;

// Funkce pro generování stránky článku
function generatePostPage($post_id) {
    // Základní HTML struktura pro článek
    $html = '<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Článek - Ráj mazlíčků</title>
    
    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore-compat.js"></script>
    
    <style>
        :root {
            --primary-color: #00a79e;
            --secondary-color: #46707f;
            --accent-color: #ff6b35;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --border-radius: 12px;
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 16px 48px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: var(--light-gray);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header {
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 1rem 0;
            margin-bottom: 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            height: 50px;
        }

        .back-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            font-size: 1rem;
        }

        .back-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 167, 158, 0.3);
        }

        .blog-post {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 3rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .post-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .post-content {
            padding: 3rem;
        }

        .post-header {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--light-gray);
        }

        .post-title {
            font-family: "Oswald", sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .post-meta {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .post-date {
            background: var(--primary-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .post-category {
            background: var(--accent-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .post-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin-bottom: 2.5rem;
        }

        .post-tag {
            background: linear-gradient(135deg, var(--light-gray) 0%, #e9ecef 100%);
            color: var(--text-dark);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .post-tag:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .post-content-text {
            margin-bottom: 3rem;
        }

        .post-paragraph {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        .post-paragraph:last-child {
            margin-bottom: 0;
        }

        .post-footer {
            padding-top: 2rem;
            border-top: 2px solid var(--light-gray);
            text-align: center;
        }

        .back-to-aktuality {
            background: var(--primary-color);
            color: var(--white);
            padding: 1rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            font-size: 1.1rem;
        }

        .back-to-aktuality:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 167, 158, 0.3);
        }

        .loading {
            text-align: center;
            padding: 4rem 2rem;
            font-size: 1.2rem;
            color: var(--text-light);
        }

        .error {
            text-align: center;
            padding: 4rem 2rem;
            color: #e74c3c;
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .not-found {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-light);
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            .post-content {
                padding: 2rem;
            }
            
            .post-title {
                font-size: 2rem;
            }
            
            .post-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .post-tags {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <img src="/photo/rm-logo.png" alt="Ráj mazlíčků" class="logo">
                <a href="/aktuality" class="back-btn">← Zpět na aktuality</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="postContent" class="loading">
            Načítání článku...
        </div>
    </div>

    <script>
        // Firebase konfigurace
        const firebaseConfig = {
            apiKey: "AIzaSyBqXqXqXqXqXqXqXqXqXqXqXqXqXqXqXqXq",
            authDomain: "raj-mazlicku.firebaseapp.com",
            projectId: "raj-mazlicku",
            storageBucket: "raj-mazlicku.appspot.com",
            messagingSenderId: "123456789",
            appId: "1:123456789:web:abcdefghijklmnop"
        };

        // Inicializace Firebase
        firebase.initializeApp(firebaseConfig);
        const db = firebase.firestore();

        // Získat ID článku z URL
        function getPostIdFromUrl() {
            const path = window.location.pathname;
            const match = path.match(/\/aktuality\/(.+)$/);
            return match ? match[1] : null;
        }

        // Načíst článek
        async function loadPost() {
            const postId = getPostIdFromUrl();
            
            if (!postId) {
                document.getElementById("postContent").innerHTML = 
                    "<div class=\"error\">Chyba: ID článku nebylo nalezeno</div>";
                return;
            }

            try {
                const doc = await db.collection("posts").doc(postId).get();
                
                if (doc.exists) {
                    const post = doc.data();
                    displayPost(post);
                } else {
                    document.getElementById("postContent").innerHTML = 
                        "<div class=\"not-found\">Článek nebyl nalezen</div>";
                }
            } catch (error) {
                console.error("Chyba při načítání článku:", error);
                document.getElementById("postContent").innerHTML = 
                    "<div class=\"error\">Chyba při načítání článku</div>";
            }
        }

        // Zobrazit článek
        function displayPost(post) {
            const postContent = document.getElementById("postContent");
            
            const imageHtml = post.imageUrl ? 
                `<img src="${post.imageUrl}" alt="${post.title}" class="post-image">` : "";
            
            const tagsHtml = post.tags && post.tags.length > 0 ? 
                `<div class="post-tags">
                    ${post.tags.map(tag => `<span class="post-tag">${tag}</span>`).join("")}
                </div>` : "";
            
            const categoryHtml = post.category ? 
                `<div class="post-category">${post.category}</div>` : "";

            // Formátovat obsah s odstavci
            let formattedContent = post.content || "Obsah článku není k dispozici";
            
            // Pokud je obsah string, formátovat ho
            if (typeof formattedContent === "string") {
                // Nahradit HTML tagy za správné formátování
                formattedContent = formattedContent
                    .replace(/<br\s*\/?>/gi, "\n")
                    .replace(/<\/p>/gi, "\n")
                    .replace(/<p[^>]*>/gi, "")
                    .replace(/<[^>]*>/g, "")
                    .trim();
                
                // Rozdělit na odstavce a vytvořit HTML
                const paragraphs = formattedContent
                    .split("\n")
                    .filter(line => line.trim().length > 0)
                    .map(line => `<p class="post-paragraph">${line.trim()}</p>`)
                    .join("");
                
                formattedContent = paragraphs;
            }

            postContent.innerHTML = `
                <div class="blog-post">
                    ${imageHtml}
                    <div class="post-content">
                        <div class="post-header">
                            <h1 class="post-title">${post.title || "Bez názvu"}</h1>
                            <div class="post-meta">
                                ${post.date ? `<div class="post-date">${post.date}</div>` : ""}
                                ${categoryHtml}
                            </div>
                        </div>
                        
                        ${tagsHtml}
                        
                        <div class="post-content-text">
                            ${formattedContent}
                        </div>
                        
                        <div class="post-footer">
                            <a href="/aktuality" class="back-to-aktuality">
                                ← Zpět na všechny aktuality
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }

        // Načíst článek při načtení stránky
        document.addEventListener("DOMContentLoaded", loadPost);
    </script>
</body>
</html>';

    return $html;
}

// Funkce pro generování moderní 404 error stránky
function generateErrorPage($path) {
    $html = '<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Stránka nenalezena | Ráj mazlíčků</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #00a79e;
            --secondary-color: #46707f;
            --accent-color: #ff6b35;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --border-radius: 12px;
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 16px 48px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: linear-gradient(135deg, var(--light-gray) 0%, var(--white) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            max-width: 600px;
            text-align: center;
            padding: 3rem 2rem;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            animation: slideInUp 0.6s ease-out;
        }

        .error-icon {
            font-size: 6rem;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }

        .error-title {
            font-family: "Oswald", sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .error-subtitle {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .error-path {
            background: var(--light-gray);
            padding: 1rem;
            border-radius: var(--border-radius);
            font-family: "Courier New", monospace;
            color: var(--text-dark);
            margin-bottom: 2rem;
            border-left: 4px solid var(--accent-color);
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .error-btn {
            display: inline-block;
            padding: 1rem 2rem;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .error-btn.primary {
            background: var(--primary-color);
            color: var(--white);
        }

        .error-btn.primary:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .error-btn.secondary {
            background: var(--white);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .error-btn.secondary:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .error-suggestions {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--light-gray);
        }

        .error-suggestions h3 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
            font-family: "Oswald", sans-serif;
        }

        .error-suggestions ul {
            list-style: none;
            text-align: left;
            max-width: 400px;
            margin: 0 auto;
        }

        .error-suggestions li {
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--light-gray);
        }

        .error-suggestions a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .error-suggestions a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @media (max-width: 768px) {
            .error-container {
                margin: 1rem;
                padding: 2rem 1rem;
            }
            
            .error-title {
                font-size: 2.5rem;
            }
            
            .error-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .error-btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">🐾</div>
        <h1 class="error-title">404</h1>
        <p class="error-subtitle">Ups! Tato stránka se ztratila v Ráji mazlíčků</p>
        
        <div class="error-path">
            Požadovaná adresa: <strong>' . htmlspecialchars($path) . '</strong>
        </div>
        
        <div class="error-actions">
            <a href="/" class="error-btn primary">🏠 Hlavní stránka</a>
            <a href="/aktuality" class="error-btn secondary">📰 Aktuality</a>
        </div>
        
        <div class="error-suggestions">
            <h3>Možná jste hledali:</h3>
            <ul>
                <li><a href="/karlovy-vary">🏪 Pobočka Karlovy Vary</a></li>
                <li><a href="/chodov">🏪 Pobočka Chodov</a></li>
                <li><a href="/cheb">🏪 Pobočka Cheb</a></li>
                <li><a href="/akvaterachodov">🐟 Trhy Chodov</a></li>
                <li><a href="/akvateracheb">🐟 Trhy Cheb</a></li>
            </ul>
        </div>
    </div>
</body>
</html>';

    return $html;
}
?>
