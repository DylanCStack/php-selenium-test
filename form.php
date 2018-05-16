<?php

function logIt($args) {
  file_put_contents(__DIR__.'/log.log', date('D, d/m h:m:s').PHP_EOL.print_r($args, true), FILE_APPEND);
}

logIt($_POST);

header('Location: http://localhost:8000/form2.html');