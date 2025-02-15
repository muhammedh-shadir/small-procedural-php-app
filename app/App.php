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

function getTransactions(string $fileName): array {
    if (! file_exists($fileName)) {
        trigger_error('File does not exist', E_USER_ERROR);
    }

    $file = fopen($fileName, 'r');
    fgetcsv($file);
    $transactions = [];

    while (($transaction = fgetcsv($file)) !== false) {
        $transactions[] = $transaction;
    }

    return $transactions;
}