<?php

class DbModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = getDb();
    }

    public function all(string $table, string $orderBy = 'id DESC'): array
    {
        $stmt = $this->db->query("SELECT * FROM {$table} ORDER BY {$orderBy}");
        return $stmt->fetchAll();
    }

    public function findById(string $table, int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function insert(string $table, array $data): int
    {
        $fields = array_keys($data);
        $placeholders = array_map(fn($field) => ':' . $field, $fields);
        $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $placeholders) . ')';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(string $table, int $id, array $data): bool
    {
        $sets = [];
        foreach ($data as $key => $value) {
            $sets[] = $key . ' = :' . $key;
        }
        $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $sets) . ' WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete(string $table, int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM ' . $table . ' WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}
