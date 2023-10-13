<?php 
// namespace Liberius\app\ancient;

function parseEnv($filePath) {
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($lines === false) {
        throw new Exception('Failed to read the .env file');
    }

    foreach ($lines as $line) {
        if (strpos($line, '=') === false || substr($line, 0, 1) === '#') {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        if (!empty($key)) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

try {
    parseEnv(__DIR__ . '/../../.env');
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
