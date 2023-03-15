<?php

use App\Entity\Formation;
use PHPUnit\Framework\TestCase;

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class DateTest extends TestCase{
    
    public function testGetPublishedAtString()
    {
        // Créer une nouvelle formation
        $formation = new Formation();

        // Définir une date de publication pour la formation
        $datePublication = new DateTime('2022-01-01');
        $formation->setPublishedAt($datePublication);

        // Appeler la fonction getPublishedAtString()
        $datePublicationString = $formation->getPublishedAtString();

        // Vérifier que la date de publication est bien formatée en string
        $this->assertEquals('01/01/2022', $datePublicationString);
    }

    public function testGetPublishedAtStringWithNullDate()
    {
        // Créer une nouvelle formation sans date de publication
        $formation = new Formation();

        // Appeler la fonction getPublishedAtString()
        $datePublicationString = $formation->getPublishedAtString();

        // Vérifier que la date de publication est vide
        $this->assertEquals('', $datePublicationString);
    }

}