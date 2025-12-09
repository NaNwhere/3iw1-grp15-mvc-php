<?php
namespace App\Core;

/**
 * Class Model
 * Modèle de base pour l'interaction avec la base de données.
 */
abstract class Model
{
    protected $table;
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Trouve tous les enregistrements.
     * @return array
     */
    public function findAll()
    {
        $stmt = $this->db->query("SELECT * FROM " . $this->table);
        return $stmt->fetchAll();
    }

    /**
     * Trouve un enregistrement par son ID.
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Trouve un enregistrement par une colonne spécifique.
     * @param string $column
     * @param mixed $value
     * @return mixed
     */
    public function findBy($column, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->table . " WHERE $column = ?");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    /**
     * Supprime un enregistrement.
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM " . $this->table . " WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
