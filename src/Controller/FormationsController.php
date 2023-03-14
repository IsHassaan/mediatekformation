<?php
namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur des formations
 *
 * @author emds
 */
class FormationsController extends AbstractController {

    const LIEN = "pages/formations.html.twig";
    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;
    
    function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository= $categorieRepository;
    }
    

    
    /**
     * @Route("/formations", name="formations")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::LIEN, [
        'formations' => $formations,
        'categories' => $categories
        ]);
    }

    /**
     * @Route("/formations/tri/{champ}/{ordre}/{table}", name="formations.sort")
     * @param type $champ
     * @param type $ordre
     * @param type $table
     * @return Response
     */
    public function sort($champ, $ordre, $table=""): Response{
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::LIEN, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }     
    
    /**
     * @Route("/formations/recherche/{champ}/{table}", name="formations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::LIEN, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }  
    
    /**
     * @Route("/formations/formation/{id}", name="formations.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response{
        $formation = $this->formationRepository->find($id);
        return $this->render(self::LIEN, [
            'formation' => $formation
        ]);        
    }   
    
    
    
    /**
     * @Route("/formation/{id}/delete", name="formation_delete")
     * @param Formation $formation
     * @return RedirectResponse
     */
    public function suppr(Formation $formation): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($formation);
        $em->flush();

        return $this->redirectToRoute("formations");
    }
    
    /**
     * @Route("/formation/{id}/edit", name="formation_edit")
     * @param Formation $formation
     * @return Response
     * @param Request $request
     */
    public function edit(Formation $formation, Request $request):Response{
        $formFormation = $this->createForm(FormationType::class, $formation);
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted()&& $formFormation->isValid()){
            $this->formationRepository->add($formation, true);
            return $this->redirectToRoute('formations');
        }
         return $this->render("pages/editFormation.html.twig",[
            'formation'=>$formation,
             'formFormation' =>$formFormation->createView()
        ]);
    }
    
    
  /**
     * @Route("/formation/ajout", name="formation_ajout")
     * @param Formation $formation
     * @return Response
     * @param Request $request
     */
    public function ajout(Request $request):Response{
        $formation=new Formation();
        $formFormation = $this->createForm(FormationType::class, $formation);
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted()&& $formFormation->isValid()){
            $this->formationRepository->add($formation, true);
            return $this->redirectToRoute('formations');
        }
         return $this->render("pages/ajoutFormation.html.twig",[
            'formation'=>$formation,
             'formFormation' =>$formFormation->createView()
        ]);
    }
}
