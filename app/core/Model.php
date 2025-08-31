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
     * Magic getter for relationship properties.
     * 
     * @param string $name Property name
     * @return mixed Relationship result or null
     */
    public function __get($name)
    {
        // If trying to access a relationship method as a property
        if (method_exists($this, $name)) {
            $result = $this->$name();
            $this->$name = $result; // Cache the result
            return $result;
        }

        return null;
    }

    /**
     * Inserts a new record into the database using the provided data.
     * Only fillable fields are used.
     *
     * @param array $data Data to insert (fillable fields only)
     * @param bool $returnId Return last insert ID instead of bool
     * @return bool|int True/ID on success, false on failure
     */
    public static function insert(array $data, bool $returnId = false): bool|int
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

        if ($stmt->execute()) {
            return $returnId ? Application::$app->db->pdo->lastInsertId() : true;
        }

        return false;
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
     * Counts records matching given conditions.
     *
     * @param array $conditions ['column' => 'value']
     * @return int
     */
    public static function countWhere(array $conditions): int
    {
        $table = static::tableName();
        $columns = array_keys($conditions);
        $whereParts = [];

        foreach ($conditions as $key => $value) {
            if ($value === null) {
                $whereParts[] = "$key IS NULL";
            } else {
                $whereParts[] = "$key = :$key";
            }
        }

        $whereClause = implode(' AND ', $whereParts);

        $sql = "SELECT COUNT(*) FROM $table WHERE $whereClause";
        $stmt = static::prepare($sql);

        foreach ($conditions as $key => $value) {
            if ($value !== null) {
                $stmt->bindValue(":$key", $value);
            }
        }

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
     * Fetch recent records ordered by a column, with limit.
     *
     * @param string $orderBy Column to order by (e.g., created_at)
     * @param string $direction Sort direction (ASC or DESC)
     * @param int $limit Number of records to fetch
     * @return array
     */
    public static function recent(string $orderBy = 'created_at', string $direction = 'DESC', int $limit = 5): array
    {
        $table = static::tableName();

        $sql = "SELECT * FROM $table ORDER BY $orderBy $direction LIMIT :limit";
        $stmt = static::prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return  $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    /**
     * Fetch recent records ordered by a column, with limit and eager loading.
     *
     * @param array $relationships Array of relationship method names to load
     * @param string $orderBy Column to order by (e.g., created_at)
     * @param string $direction Sort direction (ASC or DESC)
     * @param int $limit Number of records to fetch
     * @return array
     */
    public static function recentWith(array $relationships = [], string $orderBy = 'created_at', string $direction = 'DESC', int $limit = 5): array
    {
        $table = static::tableName();

        $sql = "SELECT * FROM $table ORDER BY $orderBy $direction LIMIT :limit";
        $stmt = static::prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        $records = $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);

        // Load relationships for each record
        foreach ($records as $record) {
            foreach ($relationships as $relationship) {
                if (method_exists($record, $relationship)) {
                    $record->$relationship = $record->$relationship();
                    
                    // Handle nested relationships (e.g., 'orderItems.items')
                    if (strpos($relationship, '.') !== false) {
                        $parts = explode('.', $relationship);
                        $mainRelation = $parts[0];
                        $nestedRelation = $parts[1];
                        
                        if (method_exists($record, $mainRelation)) {
                            $record->$mainRelation = $record->$mainRelation();
                            
                            // Load nested relationship for each item in the collection
                            if (is_array($record->$mainRelation)) {
                                foreach ($record->$mainRelation as $item) {
                                    if (method_exists($item, $nestedRelation)) {
                                        $item->$nestedRelation = $item->$nestedRelation();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $records;
    }

    /**
     * Fetches recent records filtered by given conditions.
     *
     * @param array $conditions Key-value pairs for WHERE clause (e.g. ['role' => 'customer'])
     * @param int $limit Number of recent records to fetch, defaults to 5
     * @return array List of model objects ordered by 'created_at' descending
     */
    public static function recentWhere(array $conditions, string $orderBy = 'created_at', string $order = 'DESC', int $limit = 5): array
    {
        $table = static::tableName();
        $whereParts = [];
        foreach ($conditions as $key => $value) {
            if ($value === null) {
                $whereParts[] = "$key IS NULL";
            } else {
                $whereParts[] = "$key = :$key";
            }
        }
        $whereClause = implode(' AND ', $whereParts);

        $sql = "SELECT * FROM $table WHERE $whereClause ORDER BY $orderBy $order LIMIT :limit";
        $stmt = self::prepare($sql);

        foreach ($conditions as $key => $value) {
            if ($value !== null) {
                $stmt->bindValue(":$key", $value);
            }
        }
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    /**
     * Finds one record with conditions (supports null).
     * Example: find user by email or id.
     *
     * @param array $conditions ['column' => 'value']
     * @return static|null
     */
    public static function where(array $conditions)
    {
        $table = static::tableName();
        $columns = array_keys($conditions);
        $whereParts = [];

        foreach ($conditions as $key => $value) {
            if ($value === null) {
                $whereParts[] = "$key IS NULL";
            } else {
                $whereParts[] = "$key = :$key";
            }
        }

        $whereClause = implode(' AND ', $whereParts);

        $sql = "SELECT * FROM $table WHERE $whereClause";
        $stmt = self::prepare($sql);

        foreach ($conditions as $key => $value) {
            if ($value !== null) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }

    /**
     * Find records by multiple conditions.
     *
     * @param array $conditions Key-value pairs for WHERE clause
     * @param bool $single If true, return a single model instance or null
     * 
     * @return static[]|static|null  Returns:
     *   - static|null if $single = true
     *   - static[]   if $single = false
     */
    public static function whereMany(array $conditions, bool $single = false)
    {
        $table = static::tableName();
        $whereParts = [];

        foreach ($conditions as $key => $value) {
            if ($value === null) {
                $whereParts[] = "$key IS NULL";
            } else {
                $whereParts[] = "$key = :$key";
            }
        }

        $whereClause = implode(' AND ', $whereParts);
        $sql = "SELECT * FROM $table WHERE $whereClause";
        if ($single) {
            $sql .= " LIMIT 1"; // <-- Only get one row
        }

        $stmt = self::prepare($sql);

        foreach ($conditions as $key => $value) {
            if ($value !== null) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();

        if ($single) {
            return $stmt->fetchObject(static::class) ?: null;
        }

        return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    /**
     * Get the sum of a column with optional conditions.
     *
     * @param string $column The column to sum.
     * @param array $conditions Optional conditions ['column' => 'value'].
     * @return float
     */
    public static function sum(string $column, array $conditions = []): float
    {
        $table = static::tableName();

        $sql = "SELECT SUM($column) as total FROM $table";

        if (!empty($conditions)) {
            $whereParts = [];

            foreach ($conditions as $key => $value) {
                if ($value === null) {
                    $whereParts[] = "$key IS NULL";
                } else {
                    $whereParts[] = "$key = :$key";
                }
            }

            $whereClause = implode(' AND ', $whereParts);
            $sql .= " WHERE $whereClause";
        }

        $stmt = self::prepare($sql);

        foreach ($conditions as $key => $value) {
            if ($value !== null) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result['total'] !== null ? (float)$result['total'] : 0.0;
    }

    /**
     * Group records by a column and sum another column.
     *
     * @param string $groupByColumn Column to group by
     * @param string $sumColumn Column to sum
     * @param array $conditions Optional WHERE conditions
     * @param string $orderBy Optional ORDER BY column (defaults to sum column DESC)
     * @return array Array of objects with group and total properties
     */
    public static function groupBySum(string $groupByColumn, string $sumColumn, array $conditions = [], string $orderBy = null): array
    {
        $table = static::tableName();
        $orderBy = $orderBy ?: "total DESC";

        $sql = "SELECT $groupByColumn as `group`, SUM($sumColumn) as total FROM $table";

        if (!empty($conditions)) {
            $whereParts = [];
            foreach ($conditions as $key => $value) {
                // Handle comparison operators in key
                if (strpos($key, ' ') !== false) {
                    // Key contains operator like 'quantity >'
                    $whereParts[] = "$key :param_" . str_replace(' ', '_', $key);
                } elseif ($value === null) {
                    $whereParts[] = "$key IS NULL";
                } else {
                    $whereParts[] = "$key = :$key";
                }
            }
            $whereClause = implode(' AND ', $whereParts);
            $sql .= " WHERE $whereClause";
        }

        $sql .= " GROUP BY $groupByColumn ORDER BY $orderBy";

        $stmt = self::prepare($sql);

        foreach ($conditions as $key => $value) {
            if ($value !== null) {
                if (strpos($key, ' ') !== false) {
                    // Handle operator keys
                    $paramName = ':param_' . str_replace(' ', '_', $key);
                    $stmt->bindValue($paramName, $value);
                } else {
                    $stmt->bindValue(":$key", $value);
                }
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * BelongsTo relationship - Get the parent model.
     *
     * @param string $relatedModel
     * @param string $foreignKey
     * @return object|null
     */
    public function belongsTo(string $relatedModel, string $foreignKey = null)
    {
        if (!$foreignKey) {
            $foreignKey = strtolower(self::getClassName($relatedModel)) . '_id';
        }

        // Return empty object if foreign key isn't set
        if (empty($this->$foreignKey)) {
            return new $relatedModel();
        }

        $relatedTable = $relatedModel::tableName();
        $relatedPrimaryKey = $relatedModel::primaryKey();

        $sql = "SELECT * FROM $relatedTable WHERE $relatedPrimaryKey = :foreign_key LIMIT 1";
        $stmt = self::prepare($sql);
        $stmt->bindValue(':foreign_key', $this->$foreignKey);
        $stmt->execute();

        return $stmt->fetchObject($relatedModel) ?: new $relatedModel();
    }

    /**
     * HasMany relationship - Get child models.
     *
     * @param string $relatedModel
     * @param string $foreignKey
     * @return array
     */
    public function hasMany(string $relatedModel, string $foreignKey = null)
    {
        if (!$foreignKey) {
            $foreignKey = strtolower(self::getClassName(static::class)) . '_id';
        }

        $relatedTable = $relatedModel::tableName();
        $currentPrimaryKey = static::primaryKey();

        $sql = "SELECT * FROM $relatedTable WHERE $foreignKey = :current_id";
        $stmt = self::prepare($sql);
        $stmt->bindValue(':current_id', $this->$currentPrimaryKey);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, $relatedModel);
    }

    /**
     * Eager load relationships
     *
     * @param array $relations
     * @return array
     */
    public static function with(array $relations): array
    {
        $models = self::all();
        $result = [];

        foreach ($models as $model) {
            foreach ($relations as $relationPath) {
                self::eagerLoadRelation($model, explode('.', $relationPath));
            }
            $result[] = $model;
        }

        return $result;
    }

    /**
     * Recursively eager-load nested relationships on a model.
     *
     * @param object $model       The model instance.
     * @param array  $segments    Relationship path split by dot notation.
     */
    private static function eagerLoadRelation(&$model, array $segments)
    {
        if (!$model || empty($segments)) return;

        $relationName = array_shift($segments);

        if (!method_exists($model, $relationName)) return;

        // Get and attach the relationship
        $related = $model->$relationName();
        $model->$relationName = $related;

        // Continue loading nested relationships if they exist
        if (!empty($segments) && $related) {
            if (is_array($related)) {
                foreach ($related as &$relatedItem) {
                    self::eagerLoadRelation($relatedItem, $segments);
                }
            } elseif (is_object($related)) {
                self::eagerLoadRelation($related, $segments);
            }
        }
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
     * Helper function to get class name without namespace
     */
    private static function getClassName($class)
    {
        $parts = explode('\\', $class);
        return end($parts);
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
