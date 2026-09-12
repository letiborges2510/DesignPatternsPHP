<?php
require 'vendor/autoload.php';

use DesignPatterns\Structural\Adapter\Kindle;
use DesignPatterns\Structural\Adapter\EBookAdapter;

$kindle = new Kindle();
$book = new EBookAdapter($kindle);

$book->open();
$book->turnPage();

echo $book->getPage(); 