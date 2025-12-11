<?php
namespace App\Core;

class Validator
{
    private $data;
    private $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    public function required($field)
    {
        if (!isset($this->data[$field]) || trim($this->data[$field]) === '') {
            $this->errors[$field][] = "Le champ $field est requis.";
        }
    }

    public function min($field, $minLength)
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $minLength) {
            $this->errors[$field][] = "Le champ $field doit contenir au moins $minLength caractères.";
        }
    }

    public function email($field)
    {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "L'email n'est pas valide.";
        }
    }

    public function password($field)
    {
        if (isset($this->data[$field])) {
            if (strlen($this->data[$field]) < 8 || 
                !preg_match('/[a-zA-Z]/', $this->data[$field]) || 
                !preg_match('/[0-9]/', $this->data[$field])) {
                $this->errors[$field][] = "Le mot de passe doit faire au moins 8 caractères et contenir des lettres et des chiffres.";
            }
        }
    }

    public function match($field, $otherField)
    {
        if (isset($this->data[$field]) && isset($this->data[$otherField]) && $this->data[$field] !== $this->data[$otherField]) {
            $this->errors[$field][] = "Les champs ne correspondent pas.";
        }
    }
    
    public function unique($field, $table, $column, $exceptId = null)
    {
        if (isset($this->data[$field])) {
            $db = Database::getInstance()->getConnection();
            
            $sql = "SELECT COUNT(*) FROM $table WHERE $column = :value";
            $queryParams = [':value' => $this->data[$field]];

            if ($exceptId) {
                $sql .= " AND id != :id";
                $queryParams[':id'] = $exceptId;
            }

            $stmt = $db->prepare($sql);
            $stmt->execute($queryParams);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $this->errors[$field][] = "La valeur du champ $field est déjà utilisée.";
            }
        }
    }
}
