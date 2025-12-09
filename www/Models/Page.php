<?php
namespace App\Models;

use App\Core\Model;

class Page extends Model
{
    protected $table = 'pages';

    /**
     * Crée une nouvelle page.
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table} (title, slug, content) VALUES (:title, :slug, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $data['content']
        ]);
    }

    /**
     * Met à jour une page.
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        $sql = "UPDATE {$this->table} SET title = :title, slug = :slug, content = :content, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $data['content']
        ]);
    }
}
