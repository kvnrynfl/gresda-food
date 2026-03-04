<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | Gresda Food</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            color: #e2e8f0;
        }
        .container {
            text-align: center;
            padding: 2rem;
            animation: fadeIn 0.6s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .error-code {
            font-size: 8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #06b6d4, #0891b2, #0e7490);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin-bottom: 1rem;
        }
        .emoji { font-size: 4rem; margin-bottom: 1.5rem; }
        h1 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.75rem; color: #f1f5f9; }
        p { font-size: 1rem; color: #94a3b8; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto; }
        .btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #0891b2, #06b6d4);
            color: #fff;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(8, 145, 178, 0.3);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(8, 145, 178, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-code">404</div>
        <div class="emoji">🍽️</div>
        <h1>Halaman Tidak Ditemukan</h1>
        <p>Maaf, halaman yang Anda cari tidak tersedia. Mungkin sudah dipindahkan atau dihapus.</p>
        <a href="<?= defined('BASEURL') ? BASEURL : '/' ?>" class="btn">← Kembali ke Beranda</a>
    </div>
</body>
</html>
