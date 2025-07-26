<?php

namespace app\core;

/**
 * Handles file uploads from HTTP requests.
 *
 * This class allows you to fetch a file from the request and store it
 * in a specific folder with an optional custom filename.
 */
class FileHandler
{
    // The uploaded file from the $_FILES array
    protected $file;

    // The name of the input field (e.g., 'image')
    protected $field;

    /**
     * Constructor that accepts the uploaded file array and field name.
     *
     * @param array $file  The $_FILES[field] data.
     * @param string $field  The field name (e.g., 'image').
     */
    public function __construct(array $file, string $field)
    {
        $this->file  = $file;
        $this->field = $field;
    }

    /**
     * Static method to create a FileHandler instance from a form request.
     *
     * @param string $field  The name of the input field.
     * @return self|null  Returns a FileHandler object or null if upload failed.
     */
    public static function fromRequest(string $field): ?self
    {
        // Check if file exists and was uploaded without error
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        return new self($_FILES[$field], $field);
    }

    /**
     * Moves the uploaded file to the specified folder with a generated or custom filename.
     *
     * @param string $folder  The destination folder (relative to project root).
     * @param string|null $name  Optional custom filename.
     * @return string|null  The saved filename, or null on failure.
     */
    public function store(string $folder = 'public/storage', ?string $name = null): ?string
    {
        $ext = strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));       // Get file extension
        $safeName = $name ?: uniqid($this->field . '_') . '.' . $ext;               // Generate unique filename if none provided
        $folderPath = dirname(__DIR__, 2) . '/' . trim($folder, '/');               // Build the full path to the target folder

        // Create the folder if it doesn't exist
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        // Final path where the uploaded file will be stored
        $targetPath = $folderPath . '/' . $safeName;

        // Move the uploaded file to the target location
        if (move_uploaded_file($this->file['tmp_name'], $targetPath)) {
            return $safeName; // Return just the filename (not full path)
        }

        return null;
    }
}
