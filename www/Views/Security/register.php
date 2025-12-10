<div class="max-w-md mx-auto">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Inscription</h1>
        <p class="mt-2 text-gray-600">Créez votre compte en quelques secondes</p>
    </div>

    <?php if (isset($errors)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                </div>
                <div class="ml-3">
                    <ul class="list-disc list-inside text-sm text-red-700">
                        <?php foreach ($errors as $fieldErrors): ?>
                            <?php foreach ($fieldErrors as $err): ?>
                                <li><?= $this->e($err) ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700"><?= $this->e($error) ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <form action="/register" method="POST" class="space-y-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="firstname" class="block text-sm font-medium text-gray-700">Prénom</label>
                <div class="mt-1">
                    <input type="text" id="firstname" name="firstname" required value="<?= isset($data['firstname']) ? $this->e($data['firstname']) : '' ?>"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>
            <div>
                <label for="lastname" class="block text-sm font-medium text-gray-700">Nom</label>
                <div class="mt-1">
                    <input type="text" id="lastname" name="lastname" required value="<?= isset($data['lastname']) ? $this->e($data['lastname']) : '' ?>"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
            <div class="mt-1">
                <input type="email" id="email" name="email" required value="<?= isset($data['email']) ? $this->e($data['email']) : '' ?>"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <div class="mt-1">
                <input type="password" id="password" name="password" required 
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </div>

        <div>
            <label for="password_confirm" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
            <div class="mt-1">
                <input type="password" id="password_confirm" name="password_confirm" required 
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                S'inscrire
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Déjà un compte ? 
            <a href="/login" class="font-medium text-indigo-600 hover:text-indigo-500">Se connecter</a>
        </p>
    </div>
</div>
