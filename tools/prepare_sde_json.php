<?php

// Prepare the data that we want represented as JSON
$d = [
   'version' => 'mosaic-1.2-112318',
   'url' => 'https://www.fuzzwork.co.uk/dump/mosaic-1.2-112318/',
   'format' => '.sql.bz2',
   'tables' => [
   ]
];

// Print the resultant JSON
print_r(json_encode($d) . PHP_EOL);

