<?php

header('Content-Type: application/json');

require './vendor/autoload.php';

$data = new \Street\Resources\CsvResource(file_get_contents(__DIR__ . '/brief/examples.csv'), true);
$exampleFeed = new \Street\DirectoryBuilder($data);
echo $exampleFeed->buildDirectory()->toJson();
