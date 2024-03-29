<?php
namespace App\Controller;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of PlaylistsController
 *
 * @author emds
 */
class PlaylistsController extends AbstractController {
    
    const LINK = "pages/playlists.html.twig";
    
    /**
     * 
     * @var PlaylistRepository
     */
    private $playlistRepository;
    
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
    
    function __construct(PlaylistRepository $playlistRepository, 
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository) {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }
    
    /**
     * @Route("/playlists", name="playlists")
     * @return Response
     */
    public function index(): Response{
        $playlists = $this->playlistRepository->findAllOrderBy('name', 'ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::LINK, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }

    /**
     * @Route("/playlists/tri/{champ}/{ordre}", name="playlists.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response{
        $playlists = $this->playlistRepository->findAllOrderBy($champ, $ordre);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::LINK, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }         
    
    /**
     * @Route("/playlists/recherche/{champ}/{table}", name="playlists.findallcontain")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::LINK, [
            'playlists' => $playlists,
            'categories' => $categories,            
            'valeur' => $valeur,
            'table' => $table
        ]);
    }  
    
    /**
     * @Route("/playlists/playlist/{id}", name="playlists.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response{
        $playlist = $this->playlistRepository->find($id);
        $playlistCategories = $this->categorieRepository->findAllForOnePlaylist($id);
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        return $this->render(self::LINK, [
            'playlist' => $playlist,
            'playlistcategories' => $playlistCategories,
            'playlistformations' => $playlistFormations
        ]);        
    }       
    
    /**
     * 
     * @var $repository
     */
    private $repository;
    
    /**
     * 
     * @param PlaylistRepository $playlistRepository
     */
    private function _construct(PlaylistRepository $playlistRepository){
        $this->repository=$playlistRepository;
    }
    
    
   /**
    * @Route("/playlist/{id}/delete", name="playlist_delete")
    * @param Playlist $playlist
    * @return RedirectResponse
    */
   public function suppr(Playlist $playlist): RedirectResponse
   {
       $formations = $playlist->getFormations();
       foreach ($formations as $formation) {
           if ($formation->getPlaylist() !== null) {
               $this->addFlash('warning', 'La playlist est liée à une formation');
               return $this->redirectToRoute('playlists');
           }
       }

       $this->playlistRepository->remove($playlist, true);
       $this->addFlash('success', 'La playlist a été supprimée avec succès');
       return $this->redirectToRoute('playlists');
   }

    
    /**
     * @Route("/playlist/{id}/edit", name="playlist_edit")
     * @param Playlist $playlist
     * @return Response
     * @param Request $request
     */
    public function edit(Playlist $playlist, Request $request):Response{
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted()&& $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist, true);
            return $this->redirectToRoute('playlists');
        }
         return $this->render("pages/editPlaylist.html.twig",[
            'playlist'=>$playlist,
             'formPlaylist' =>$formPlaylist->createView()
        ]);
    }
    
    
    
    /**
     * @Route("/playlist/ajout", name="playlist_ajout")
     * @param Playlist $playlist
     * @return Response
     * @param Request $request
     */
    public function ajout(Request $request):Response{
        $playlist=new Playlist();
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted()&& $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist, true);
            return $this->redirectToRoute('playlists');
        }
         return $this->render("pages/ajoutPlaylist.html.twig",[
            'playlist'=>$playlist,
             'formPlaylist' =>$formPlaylist->createView()
        ]);
    }
    
}
