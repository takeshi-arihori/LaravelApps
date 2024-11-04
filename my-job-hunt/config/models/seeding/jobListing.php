<?php

$jsonData = file_get_contents(__DIR__ . '/jobListing.json');
$defaultList = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    // JSON エラー内容をログ出力
    error_log('JSON Decode Error: ' . json_last_error_msg());
}

return [
    'factory' => true,
    'factory_count' => 200,
    'default_list' => $defaultList ?: []
];
