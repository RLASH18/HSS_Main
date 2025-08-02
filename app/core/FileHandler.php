<?php

namespace app\core;

/**
 * Class FileHandler
 *
 * Handles file uploads from HTTP requests.
 * Allows fetching files from the $_FILES array and storing them in a specified location.
 */
class FileHandler
{
    protected $file;        // Uploaded file array
    protected $field;       // Name of the input field (e.g., 'image')

    /**
     * Initializes a new FileHandler instance.
     * 
     * @param array $file   The uploaded file data from $_FILES.
     * @param string $field The name of the file input field.
     */
    public function __construct(array $file, string $field)
    {
        $this->file  = $file;
        $this->field = $field;
    }

    /**
     * Creates a FileHandler instance for a given input field if a file was uploaded.
     *
     * @param string $field  The input field name (e.g., 'image').
     * @return self|null     Returns an instance or null if no valid file was uploaded.
     */
    public static function fromRequest(string $field): ?self
    {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        return new self($_FILES[$field], $field);
    }

    /**
     * Stores the uploaded file in the specified folder.
     * Automatically generates a unique name if none is provided.
     *
     * @param string $folder       Destination folder (relative to project root).
     * @param string|null $name    Optional custom filename.
     * @return string|null         The saved filename or null on failure.
     */
    public function store(string $folder = 'public/storage', ?string $name = null): ?string
    {
        $ext = strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));           // Get file extension
        $safeName = $name ?: uniqid($this->field . '_') . '.' . $ext;                   // Generate unique filename if none provided
        $folderPath = dirname(__DIR__, 2) . '/' . trim($folder, '/');                   // Build the full path to the target folder

        // Create the folder if it doesn't exist
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        // Final path where the uploaded file will be stored
        $targetPath = $folderPath . '/' . $safeName;

        // Move the uploaded file to the target location and return just the filename
        if (move_uploaded_file($this->file['tmp_name'], $targetPath)) {
            return $safeName;
        }

        return null;
    }
}
