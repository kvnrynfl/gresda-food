<?php

/**
 * File Upload Handler
 * 
 * Handles secure image uploads with:
 * - MIME type validation (using finfo, not just extension)
 * - File size limits
 * - Secure random filenames
 * - Multiple upload directory support
 */
class Upload
{
    private static $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];
    private static $maxSize = 5242880; // 5MB

    /**
     * Upload an image file
     * @param array $file $_FILES array element
     * @param string $subdirectory Upload subdirectory (e.g., 'food', 'users', 'payment')
     * @return string|false Filename on success, false on failure
     */
    public static function image($file, $subdirectory = '')
    {
        // Validate upload
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return false;
        }

        // Check file size
        if ($file['size'] > self::$maxSize) {
            return false;
        }

        // Verify MIME type using finfo (not extension)
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!isset(self::$allowedTypes[$mimeType])) {
            return false;
        }

        $extension = self::$allowedTypes[$mimeType];

        // Generate secure random filename
        $filename = bin2hex(random_bytes(8)) . '_' . time() . '.' . $extension;

        // Determine upload path
        $uploadDir = __DIR__ . '/../../public/uploads';
        if ($subdirectory) {
            $uploadDir .= '/' . $subdirectory;
        }

        // Create directory if needed
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destination = $uploadDir . '/' . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename;
        }

        return false;
    }

    /**
     * Delete an uploaded file
     * @param string $filename Filename to delete
     * @param string $subdirectory Upload subdirectory
     * @return bool
     */
    public static function delete($filename, $subdirectory = '')
    {
        if (empty($filename) || $filename === 'default.jpg') {
            return false; // Don't delete default images
        }

        $path = __DIR__ . '/../../public/uploads';
        if ($subdirectory) {
            $path .= '/' . $subdirectory;
        }
        $path .= '/' . $filename;

        if (file_exists($path)) {
            return unlink($path);
        }

        return false;
    }
}
