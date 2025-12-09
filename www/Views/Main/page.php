<div class="max-w-4xl mx-auto">
    <div class="mb-8 border-b border-gray-200 pb-5">
        <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($page['title']) ?></h1>
        <p class="mt-2 text-sm text-gray-500">
            Publié le <?= date('d/m/Y', strtotime($page['created_at'])) ?>
        </p>
    </div>

    <div class="prose prose-indigo max-w-none text-gray-700">
        <?= nl2br($page['content']) ?>
    </div>
</div>
