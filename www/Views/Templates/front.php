<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Logo / Brand -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="text-2xl font-bold text-indigo-600 tracking-tight">MiniCMS</a>
            </div>

            <!-- Main Menu (Left) -->
            <div class="hidden md:flex space-x-8 ml-10">
                <a href="/" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors duration-200">Accueil</a>
                
                <?php if (!empty($menuPages)): ?>
                <div class="relative group">
                    <button class="text-gray-600 hover:text-indigo-600 font-medium inline-flex items-center transition-colors duration-200">
                        <span>Pages</span>
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left">
                        <div class="py-1">
                            <?php foreach ($menuPages as $menuPage): ?>
                                <a href="/pages/<?= htmlspecialchars($menuPage['slug']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600"><?= htmlspecialchars($menuPage['title']) ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Auth Menu (Right) -->
            <div class="flex items-center space-x-4">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 font-medium focus:outline-none transition-colors duration-200">
                            <span>Bonjour, <?= htmlspecialchars($_SESSION['user']['firstname'] ?? 'Utilisateur') ?></span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <!-- User Dropdown -->
                        <div class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right">
                            <div class="py-1">
                                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                    <a href="/admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600">Admin Panel</a>
                                <?php endif; ?>
                                <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Déconnexion</a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors duration-200">Connexion</a>
                    <a href="/register" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium transition-colors duration-200 shadow-md">Inscription</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
            <?= $content ?>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; <?= date('Y') ?> Mini CMS. Built with PHP & Tailwind CSS.
            </p>
        </div>
    </footer>
</body>
</html>
