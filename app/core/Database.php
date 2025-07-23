<?php

namespace app\core;

use PDO;

/**
 * Class Database
 *
 * Handles the application's database connection and migration system.
 * Responsible for connecting to the database, applying new migrations,
 * rolling back old ones, and maintaining a record of all applied migrations.
 */
class Database
{
    /**
     * @var PDO PDO instance representing the database connection.
     */
    public PDO $pdo;

    /**
     * Database constructor.
     *
     * Establishes the PDO connection using the provided configuration.
     *
     * @param array $config Configuration array with keys: dsn, user, and password.
     */
    public function __construct(array $config)
    {
        $dsn      = $config['dsn'] ?? '';
        $username = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Applies all new migration files found in the migrations directory.
     *
     * It compares existing migrations in the database with the files
     * present in the migration folder, executes the `up()` method of
     * each new migration, and records them into the database.
     */
    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR . '/database/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR . "/database/migrations/$migration";
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();

            $this->log("Applying migration $migration.");
            $instance->up();
            $this->log("Applied migration $migration.");

            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log('All migrations are already applied.');
        }
    }

    /**
     * Creates the `migrations` table if it doesn't exist.
     *
     * This table stores a record of all applied migrations.
     */
    public function createMigrationsTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ");
    }

    /**
     * Fetches the list of migrations that have already been applied.
     *
     * @return array Array of migration file names.
     */
    public function getAppliedMigrations(): array
    {
        $stmt = $this->pdo->prepare("SELECT migration FROM migrations");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Saves a list of newly applied migrations to the database.
     *
     * @param array $migrations Array of migration file names.
     */
    public function saveMigrations(array $migrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $migrations));
        $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $stmt->execute();
    }

    /**
     * Rolls back the most recent `$steps` number of migrations.
     *
     * It selects the latest migrations from the database and calls
     * their `down()` method to reverse the changes. Then it removes
     * them from the `migrations` table.
     *
     * @param int $steps Number of recent migrations to rollback.
     */
    public function rollbackMigrations(int $steps = 1)
    {
        $stmt = $this->pdo->prepare("SELECT migration FROM migrations ORDER BY id DESC LIMIT $steps");
        $stmt->execute();
        $migrations = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($migrations as $migration) {
            require_once Application::$ROOT_DIR . "/database/migrations/$migration";
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();

            $this->log("Rolling back migration $migration.");

            if (method_exists($instance, 'down')) {
                $instance->down();
            }

            $this->log("Rolled back migration $migration.");
        }

        $in = implode(',', array_map(fn($m) => "('$m')", $migrations));
        $this->pdo->exec("DELETE FROM migrations WHERE migration IN $in");
    }

    /**
     * Logs messages to the console with a timestamp.
     *
     * Primarily used to track migration progress when running CLI commands.
     *
     * @param string $message Message to display.
     */
    protected function log(string $message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}
