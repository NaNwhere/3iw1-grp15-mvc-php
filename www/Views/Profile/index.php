<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Mon Profil</h1>

    <?php if (isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">Votre profil a été mis à jour avec succès.</span>
        </div>
    <?php endif; ?>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form action="/profile/update" method="POST" class="p-6">
            <div class="grid grid-cols-1 gap-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" id="firstname" name="firstname" 
                               value="<?= htmlspecialchars($data['firstname'] ?? $user['firstname']) ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <?php if (isset($errors['firstname'])): ?>
                            <p class="text-red-500 text-xs italic mt-1"><?= $errors['firstname'][0] ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" id="lastname" name="lastname" 
                               value="<?= htmlspecialchars($data['lastname'] ?? $user['lastname']) ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <?php if (isset($errors['lastname'])): ?>
                            <p class="text-red-500 text-xs italic mt-1"><?= $errors['lastname'][0] ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?= htmlspecialchars($data['email'] ?? $user['email']) ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <?php if (isset($errors['email'])): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $errors['email'][0] ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <?php if (isset($errors['password'])): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $errors['password'][0] ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Mettre à jour
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-10">
        <h2 class="text-lg font-medium text-red-600 mb-4">Zone de danger</h2>
        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <h3 class="text-red-800 font-medium mb-2">Supprimer le compte</h3>
            <p class="text-red-600 text-sm mb-4">Cette action est irréversible. Toutes vos données ainsi que les pages que vous avez créées seront supprimées.</p>
            <form action="/profile/delete" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Supprimer mon compte
                </button>
            </form>
        </div>
    </div>
</div>
