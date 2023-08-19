<?php

namespace App\Classe; // Correction de ':' en ';'

use App\Entity\Category; // Correction de 'Use' en 'use'

class Search // Ajout d'un espace après le mot-clé 'class'
{
    /**
     * @var string
     */
    public $string = ''; // Ajout d'un point-virgule à la fin

    /**
     * @var Category[]
     */
    public $categories = []; // Ajout d'un point-virgule à la fin
}

?>
