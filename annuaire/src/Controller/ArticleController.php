<?php 

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Auteur;
use App\Entity\Commentaire;
use App\Form\ArticleType;
use App\Form\CommentaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// préfixe de route 
#[Route("/article")]
class ArticleController extends AbstractController{

   


    #[Route("/new" , name:"article_new")] // /article/new
    public function new(Request $request , ManagerRegistry $doctrine): Response {
        $article = new Article();
        $form = $this->createForm(ArticleType::class , $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("article_new");
            // regenerer le setter et getter symfony console make:migration --regenerate
            // refaire une migration symfony console make:migration
            // exécuter la migration symfony console doctrine:migrations:migrate
            // le code est le même avec ou sans relation 
        }
        return $this->render("article/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

     // ATTENTION à l'ordre des méthodes (et des routes associées)
     // plus précise => new => moins précis 1,2
     // avec new => je ne peux plus voir cette page
     #[Route("/{id}" , name:"article_single")]
     public function single($id, ManagerRegistry $doctrine , Request $request) :Response{
         $article = $doctrine->getRepository(Article::class)->find($id); 

         $commentaire = new Commentaire();
         $formCommentaire = $this->createForm(CommentaireType::class , $commentaire);

        $formCommentaire->handleRequest($request);

        if($formCommentaire->isSubmitted() && $formCommentaire->isValid()){
            // associer l'article au commentaire
            $commentaire->setArticle($article);
            $em = $doctrine->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute("article_single" , ["id" => $article->getId()]);
        }

         return $this->render("article/single.html.twig" , [
            "article" => $article,
            "formCommentaire" => $formCommentaire->createView()
        ]);
        // {{ form(formCommentaire) }} en dessous du titre h2
     }
    

    #[Route("/" , name:"article_home")]
    public function index(ManagerRegistry $doctrine) : Response{
        // Afficher tous les articles quelque soit d'auteur
        $articles = $doctrine->getRepository(Article::class)->findAll(); 
        // dd($articles);
        return $this->render("article/index.html.twig" , [
            "articles" => $articles
        ]);
    }


}