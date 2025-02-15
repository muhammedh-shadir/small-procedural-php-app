<?php

declare(strict_types=1);

function getTransactionFiles(string $dirName): array {

    $files = [];
    foreach(scandir(FILES_PATH) as $file) {
        if (is_dir($file)) {
            continue;
        }

        $files[] = $dirName . $file;
    }

    return $files;
}