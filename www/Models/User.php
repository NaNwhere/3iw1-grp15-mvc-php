<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';

    /**
     * Crée un nouvel utilisateur.
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table} (firstname, lastname, email, password, verification_token) VALUES (:firstname, :lastname, :email, :password, :verification_token)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'verification_token' => $data['verification_token']
        ]);
    }

    /**
     * Vérifie si l'email existe déjà.
     * @param string $email
     * @return bool
     */
    public function emailExists($email)
    {
        $user = $this->findBy('email', $email);
        return $user !== false;
    }

    public function update($id, array $data)
    {
        $sql = "UPDATE {$this->table} SET firstname = :firstname, lastname = :lastname, email = :email, role = :role, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'role' => $data['role'] ?? 'user'
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function setResetToken($email, $token)
    {
        // Expire dans 1 heure
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $stmt = $this->db->prepare("UPDATE {$this->table} SET reset_token = ?, reset_expires_at = ? WHERE email = ?");
        return $stmt->execute([$token, $expiresAt, $email]);
    }

    public function findByResetToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE reset_token = ? AND reset_expires_at > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function updatePassword($id, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE {$this->table} SET password = ?, reset_token = NULL, reset_expires_at = NULL WHERE id = ?");
        return $stmt->execute([$hash, $id]);
    }
    public function verifyAccount($id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_verified = TRUE, verification_token = NULL WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
