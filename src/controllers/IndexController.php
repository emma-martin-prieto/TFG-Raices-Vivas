<?php
namespace RaicesVivas\Controllers;

class IndexController {

    /*Muestra la página principal (index)*/
    public function showIndex(): void {
        ViewController::show('views/index/showIndex.php');
    }
}