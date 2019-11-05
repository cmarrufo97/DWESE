<?php
echo "Estoy en el archivo uno.php\n";

require(__DIR__ .'/sub/dos.php');
require 'tres.php';

echo "Sigo en el archivo uno.php\n";
