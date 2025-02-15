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

function getTransactions(string $fileName, ?callable $transactionHandler = null): array {
    if (! file_exists($fileName)) {
        trigger_error('File does not exist', E_USER_ERROR);
    }

    $file = fopen($fileName, 'r');
    fgetcsv($file);
    $transactions = [];

    while (($transaction = fgetcsv($file)) !== false) {
        if ($transactionHandler !== null) {
            $transaction = $transactionHandler($transaction);
        }
        $transactions[] = $transaction;
    }

    return $transactions;
}

function extractTransaction(array $transactionRow) : array {

    [$date, $checkNumber, $description, $amount] = $transactionRow;

    $amount = (float) str_replace(['$', ','], '', $amount);
    return [
        'date' => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount' => $amount
    ];
}