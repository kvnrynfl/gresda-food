<?php

class Upload {
    private static $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private static $maxSize = 5 * 1024 * 1024; // 5 MB

    public static function image($file, $destinationDir) {
        // Check if file was uploaded without errors
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['status' => false, 'message' => 'Invalid parameters.'];
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return ['status' => false, 'message' => 'No file sent.'];
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return ['status' => false, 'message' => 'Exceeded filesize limit.'];
            default:
                return ['status' => false, 'message' => 'Unknown errors.'];
        }

        if ($file['size'] > self::$maxSize) {
            return ['status' => false, 'message' => 'Exceeded filesize limit.'];
        }

        // Verify MIME type using Fileinfo for true type checking
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $ext = array_search(
            $finfo->file($file['tmp_name']),
            self::$allowedMimeTypes,
            true
        );

        if ($ext === false) {
            return ['status' => false, 'message' => 'Invalid file format.'];
        }

        // Create secure filename
        $fileName = sprintf('%s.%s', sha1_file($file['tmp_name']), $ext);
        $uploadFilePath = $destinationDir . '/' . $fileName;

        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            return ['status' => true, 'filename' => $fileName];
        }

        return ['status' => false, 'message' => 'Failed to move uploaded file.'];
    }
}
