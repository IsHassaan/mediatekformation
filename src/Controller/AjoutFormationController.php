<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjoutFormationController extends AbstractController
{
    /**
     * @Route("/ajout-formation", name="ajout-formation")
     */
    public function ajoutFormation(): Response
    {
        return $this->render('pages/ajoutFormation.html.twig');
    }
}