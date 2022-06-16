<?php 

namespace App\Controller ;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

    #[Route("/" , name:"home_accueil")]
    public function home( ArticleRepository $article ):Response{
        $articles = $article->findAll();
        return $this->render("home/index.html.twig", [ "articles" => $articles ]);
    }

    #[Route("/new" , name:"home_new")]
    public function new(): Response{
        return $this->render("home/new.html.twig");
    }

    #[Route("/new-form", name:"home_new_form")]
    public function new_form(Request $request , ManagerRegistry $doctrine) :Response {
        // $_POST 
        // Request class de Symfony qui contient toutes le super globales 
        // $_POST // $_GET ... 
        //dump($request); 
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article); 
        $form->handleRequest($request); // récupére les valeurs stockées dans le $_POST
        if($form->isSubmitted() && $form->isValid()){
            $article->setDtCreation(new \DateTime()); // remplir le colonne dt_creation avec maintenant
            $em = $doctrine->getManager(); // entity Manager => 
            $em->persist($article); // créer une requête SQL => INSERT
            $em->flush();           // exécuter la requête persistée 
           // dump("l'article est enregistré en base de données"); 

            // INSERT UPDATE => $em->persist()
            // SELECT $article->findAll();
            // DELETE $em->remove()
            $this->addFlash("message" , "l'article est enregistré en base de données");
            return $this->redirectToRoute("home_new_form");
        }
        return $this->render("home/new-form.html.twig", ["form" => $form->createView()]);
    }

    #[Route("/article/update/{id}" , name:"home_modif")]
    public function article_update($id , ManagerRegistry $doctrine , Request $request) : Response{

        // récupérer l'article que l'on veut modifier 
        $article = $doctrine->getManager()->getRepository(Article::class)->find($id);
        // ?? existe
        // si non stop
        //if($article === null){ équivalent
        if(is_null($article)){
            $this->addFlash("erreur", "article numéro $id n'est existe pas");
            return $this->redirectToRoute("home_accueil");
        } 

        $form = $this->createForm(ArticleType::class , $article);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("home_accueil");
        }

        // si oui => appeler une page contenant un formulaire remplir 
        return $this->render("home/new-form.html.twig", ["form" => $form->createView()]);
    }

    #[Route("/article/delete/{id}" , name:"home_suppr")]
    public function article_delete($id, ManagerRegistry $doctrine): Response{
       // récupérer l'article que l'on veut supprimer
       $article = $doctrine->getManager()->getRepository(Article::class)->find($id);
       
       // ?? existe
        // si non stop
        if($article === null){
            $this->addFlash("erreur", "article numéro $id n'est existe pas");
            return $this->redirectToRoute("home_accueil");           
        }

        // si oui => effectuer la suppression
        $this->addFlash("message", "article numéro ". $article->getId() ." vient d'être supprimé");
        $em = $doctrine->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute("home_accueil");
    }
}