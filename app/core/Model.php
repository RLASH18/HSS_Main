<?php

namespace app\core;

/**
 * Abstract base class for database-backed models (ORM).
 *
 * Responsibilities:
 * - Defines required structure for child models (must implement `tableName`, `attributes`, `primaryKey`)
 * - Provides reusable methods for inserting, updating, and finding records
 */
abstract class Model
{
    /**
     * Must return the table name associated with the model.
     */
    abstract public static function tableName(): string;

    /**
     * Must return the list of fillable attributes for the model.
     */
    abstract public function attributes(): array;

    /**
     * Must return the name of the primary key column.
     */
    abstract public static function primaryKey(): string;

    /**
     * Inserts the current model instance into the database.
     */
    public function insert()
    {
        $table = $this->tableName();
        $columns = $this->attributes();
        $placeholders = array_map(fn($column) => ":$column", $columns);

        $stmt = self::prepare("INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(',', $placeholders) . ")");

        foreach ($columns as $column) {
            $stmt->bindValue(":$column", $this->{$column});
        }

        return $stmt->execute();
    }

    /**
     * Updates the existing model instance in the database based on its ID.
     */
    public function update()
    {
        $table = $this->tableName();
        $columns = $this->attributes();
        $primaryKey =static::primaryKey();
        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", $columns));

        $stmt = self::prepare("UPDATE $table SET $setClause WHERE $primaryKey = :$primaryKey");

        foreach ($columns as $column) {
            $stmt->bindValue(":$column", $this->{$column});
        }

        $stmt->bindValue(":$primaryKey", $this->{$primaryKey});
        return $stmt->execute();
    }

    /**
     * Finds a single record that matches the provided conditions.
     */
    public static function findOne(array $conditions)
    {
        $table = static::tableName();
        $columns = array_keys($conditions);
        $whereClause = implode(' AND ', array_map(fn($col) => "$col = :$col", $columns));

        $stmt = self::prepare("SELECT * FROM $table WHERE $whereClause");

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }

    /**
     * Utility method to prepare a PDO statement using the application's DB instance.
     */
    public static function prepare(string $sql): \PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}
