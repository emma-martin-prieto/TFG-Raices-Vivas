<?php
namespace RaicesVivas\Controllers;

class FestivalController {

    /*Muestra la página del festival*/
    public function showFestival(): void {
        ViewController::show('views/festival/showFestival.php');
    }
}