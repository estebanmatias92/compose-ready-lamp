<?php


/**
 * Get the secrets stored by Docker in the secret's volume.
 * 
 * @param string $secret_name
 * 
 * @return bool
 */
function get_secret($secret_name) {
    $secret_file = "/run/secrets/{$secret_name}";

    try {
        if (!file_exists($secret_file)) {
            throw new Exception("Secret file does not exist: {$secret_file}");
        }

        $content = file_get_contents($secret_file);
        if ($content === false) {
            // Throw an exception if the file has any error
            throw new Exception("Failed to read secret file: {$secret_file}");
        }

        return trim($content);

    } catch (Exception $e) {
        // I choose to handle the error and return false too (it could be whatever action)
        error_log($e->getMessage());
        return false; 
    }
}



// Stores every configuration detail needed in a asociative array
return [
    'database' => [
        'host' => getenv('DB_HOST'),
        'name' => getenv('DB_NAME'),
        'user' => getenv('DB_USER'),
        'pass' => get_secret('db-user-pass')
    ],
    'api_keys' => [
        // API keys and other credentials
    ],
    'app_name' => getenv('PROJECT_NAME')
];