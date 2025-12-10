<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-200">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Créer une nouvelle page</h1>

    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700 mb-2">
                    <span class="font-bold">Astuce :</span> Le slug <code class="bg-blue-100 px-1 py-0.5 rounded text-blue-800 font-mono">home</code> est magique ! Si vous l'utilisez, cette page remplacera la page d'accueil par défaut.
                </p>
                <p class="text-sm text-blue-700">
                    <span class="font-bold">Design :</span> Le HTML et les classes <span class="font-semibold">Tailwind CSS</span> fonctionnent dans le contenu. Profitez-en pour styliser vos pages !
                </p>
            </div>
        </div>
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

    <form action="/admin/pages/store" method="POST" class="space-y-6">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Titre de la page</label>
            <input type="text" id="title" name="title" required value="<?= isset($data['title']) ? $this->e($data['title']) : '' ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2 border">
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">Slug (URL)</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    /pages/
                </span>
                <input type="text" id="slug" name="slug" required value="<?= isset($data['slug']) ? $this->e($data['slug']) : '' ?>" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 border">
            </div>
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">Contenu</label>
            <div class="mt-1">
                <textarea id="content" name="content" rows="10" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"><?= isset($data['content']) ? $this->e($data['content']) : '' ?></textarea>
            </div>
            <p class="mt-2 text-sm text-gray-500">Le contenu HTML est autorisé.</p>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
            <a href="/admin/pages" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Annuler
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Publier la page
            </button>
        </div>
    </form>
</div>
