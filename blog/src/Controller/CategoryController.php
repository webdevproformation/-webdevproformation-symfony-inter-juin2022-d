<?php 
namespace App\Controller ;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController{

    #[Route("/new-categorie" , name:"categorie_new")]
    public function new_categorie( Request $request , ManagerRegistry $doctrine ) :Response{

        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class,$categorie); // créer le formulaire 

        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){ // si $_POST qui est valide 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash("message" , "la catégorie a été ajoutée en bdd");
            return $this->redirectToRoute("categorie_new");
        }

        return $this->render("categorie/new.html.twig" , ["form" => $form->createView()]); // afficher le formulaire
    }

    #[Route("/categorie", name:"categorie_index")]
    public function categorie(ManagerRegistry $doctrine) :Response{
        $categories = $doctrine->getRepository(Categorie::class)->findAll(); // SELECT * FROM categorie ; 
        // dd($categories);
        return $this->render("categorie/index.html.twig" , ["categories" => $categories]); 
    }

    #[Route("/categorie-2", name:"categorie_2_index")]
    public function categorie_2(CategorieRepository $categorieRepo) :Response{

        $categories = $categorieRepo->findAll(); // SELECT * FROM categorie ; 
        //dd($categories);
        return $this->render("categorie/index.html.twig" , ["categories" => $categories]); 
    }

    // route avec une partie variable {id} => 1, 2, 3 ....
    #[Route("/categorie/suppr/{id}", name:"categorie_suppr")]
    public function categorie_suppr($id, ManagerRegistry $doctrine){

        // récupérer la catégorie concernée 
        $categorie = $doctrine->getManager()->getRepository(Categorie::class)->find($id);
        // SELECT * FROM categorie WHERE id = 2 ; 
        // dd($categorie); 
        // $categorie => soit un tableau ou soit null 

        if($categorie !== null){
            // message => ok !!!
            $this->addFlash("message" , "la catégorie numéro " . $categorie->getId() . " a bien été supprimée"); 
            
            // si c'est bon => effectuer la suppression
            $em = $doctrine->getManager();
            $em->remove($categorie); // suppression 
            $em->flush(); 
            
        } else {
            // si la catégorie n'existe pas 
            // message non n'existe pas 
            $this->addFlash("erreur" , "la catégorie numéro " . $id . " n'existe pas"); 

        }
        return $this->redirectToRoute("categorie_index");
    }

    #[Route("/categorie/update/{id}" , name:"categorie_update")]
    public function categorie_update($id , ManagerRegistry $doctrine , Request $request){

        // rechercher l'article à modifier 
        $categorie = $doctrine->getManager()->getRepository(Categorie::class)->find($id);

        // si la catégorie n'existe pas => stop 
        if($categorie === null){
            $this->addFlash("erreur" , "la catégorie numéro " . $id . " n'existe pas"); 
            return $this->redirectToRoute("categorie_index"); 
        }

        // si la catégorie existe => générer un formulaire qui contient les données de la base de données 
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($categorie);
            $em->flush();
            $this->addFlash("message" , "la catégorie a bien été mise à jour");
            return $this->redirectToRoute("categorie_index");
        }

        return $this->render("categorie/new.html.twig", [
                                "form" => $form->createView() , 
                                "id" => $categorie->getId()
                            ]); 
        
    }
}