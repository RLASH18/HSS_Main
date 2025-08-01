<?php

namespace app\core;

/**
 * Abstract base model class for all database entities.
 *
 * This class provides a Laravel-inspired static ORM structure with reusable
 * methods for interacting with database records such as insert, update, delete,
 * fetch all, find by conditions, and count.
 *
 * Responsibilities:
 * - Enforces table, fillable, and primary key structure in child models
 * - Provides static helper methods for common CRUD operations
 */
abstract class Model
{
    /**
     * Returns the name of the database table associated with the model.
     */
    abstract public static function tableName(): string;

    /**
     * Returns the list of fillable columns allowed for insert/update.
     */
    abstract public static function fillable(): array;

    /**
     * Returns the name of the table's primary key column.
     */
    abstract public static function primaryKey(): string;

    /**
     * Inserts a new record into the database using the provided data.
     * Only fillable fields are used.
     *
     * @param array $data
     * @return bool True if insert was successful
     */
    public static function insert(array $data): bool
    {
        $data = static::filterFillable($data);
        $table = static::tableName();
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":$col", $columns);

        $sql = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = self::prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    /**
     * Updates an existing record in the database by primary key.
     * Only fillable fields are used.
     *
     * @param mixed $id The value of the primary key
     * @param array $data Key-value pairs to update
     * @return bool True if update was successful
     */
    public static function update($id, array $data): bool
    {
        $data = static::filterFillable($data);
        $table = static::tableName();
        $primaryKey = static::primaryKey();
        $columns = array_keys($data);
        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", $columns));

        $sql = "UPDATE $table SET $setClause WHERE $primaryKey = :$primaryKey";
        $stmt = self::prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(":$primaryKey", $id);
        return $stmt->execute();
    }

    /**
     * Deletes a record from the database by its primary key.
     *
     * @param mixed $id
     * @return bool True if delete was successful
     */
    public static function delete($id): bool
    {
        $table = static::tableName();
        $primaryKey = static::primaryKey();

        $sql = "DELETE FROM $table WHERE $primaryKey = :id";
        $stmt = static::prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    /**
     * Fetches all records from the model's table.
     *
     * @return array List of model objects
     */
    public static function all(): array
    {
        $table = static::tableName();

        $sql = "SELECT * FROM $table";
        $stmt = static::prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    /**
     * Returns the total number of records in the model's table.
     *
     * @return int
     */
    public static function count(): int
    {
        $table = static::tableName();

        $sql = "SELECT COUNT(*) FROM $table";
        $stmt = static::prepare($sql);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    /**
     * Finds a record by primary key.
     *
     * @param mixed $id
     * @return static|null
     */
    public static function find($id)
    {
        $table = static::tableName();
        $primaryKey = static::primaryKey();

        $sql = "SELECT * FROM $table WHERE $primaryKey = :id LIMIT 1";
        $stmt = static::prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchObject(static::class) ?: null;
    }

    /**
     * Finds a single record matching the given conditions.
     * Useful for fetching one user by email, etc.
     *
     * @param array $conditions ['column' => 'value']
     * @return static|null The matched model object or null
     */
    public static function where(array $conditions)
    {
        $table = static::tableName();
        $columns = array_keys($conditions);
        $whereClause = implode(' AND ', array_map(fn($col) => "$col = :$col", $columns));

        $sql = "SELECT * FROM $table WHERE $whereClause";
        $stmt = self::prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }

    /**
     * Filters incoming data to allow only fillable fields.
     *
     * @param array $data
     * @return array
     */
    public static function filterFillable(array $data): array
    {
        $allowed = static::fillable();
        return array_filter($data, fn($key) => in_array($key, $allowed), ARRAY_FILTER_USE_KEY);
    }

    /**
     * Prepares a PDO statement using the shared application DB connection.
     *
     * @param string $sql
     * @return \PDOStatement
     */
    public static function prepare(string $sql): \PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}
