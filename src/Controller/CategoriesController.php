<?php
namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur de l'accueil
 *
 * @author emds
 */
class CategoriesController extends AbstractController{
        
        
     /**
     * 
     * @var CategorieRepository
     */
    private $repository;
    
    /**
     * 
     * @param CategorieRepository $repository
     */
    public function __construct(CategorieRepository $repository){
        $this->repository = $repository;
    }
    
    /**
     * @Route("/categories", name="categories")
     * @return Response
     */
    public function index():Response{
        $categories = $this->repository->findAll();
        return $this->render('pages/categories.html.twig',[
            'categories'=>$categories
        ]);
    }
   
    
    
      /**
     * @Route("/pages/categories/{id}/suppr", name="categorie_delete")
     * @param Categorie $categorie
     * @return Response
     */
   public function suppr(Categorie $categorie): RedirectResponse
   {
       $formations = $categorie->getFormations();
       foreach ($formations as $categorie) {
           if ($categorie->getCategories() !== null) {
               $this->addFlash('warning', 'La categorie est liée à une formation');
               return $this->redirectToRoute('categories');
           }
       }

       $this->repository->remove($categorie, true);
       $this->addFlash('success', 'La categorie a été supprimée avec succès');
       return $this->redirectToRoute('categories');
   }
   
   
    /**
     * @Route("/pages/categories/ajout", name="categorie_ajout")
     * @param Request $request
     * @return Response
     */
      public function ajout(Request $request):Response{
      $nomCategorie = $request->get("nom");
      $categorie=new Categorie;
      $categorie->setName($nomCategorie);
      $this->repository->add($categorie, true);
      return $this->redirectToRoute('categories');
    }
}
