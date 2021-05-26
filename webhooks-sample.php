<?php

$input = file_get_contents('php://input');
$data = json_decode($input, true);

file_put_contents('log.txt', $input, FILE_APPEND);

return '200';