<?php 
namespace App\Controller ;

use App\Entity\Article;
use App\Entity\Commentaire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{
    #[Route("/" , name:"home_index")]
    public function index( ManagerRegistry $doctrine ):Response {
        // composer require profiler debug --dev
        // super barre qui va aider le développeur qui travaille sur Symfony 
        // où je suis // qu'est ce qui a été exécuté 
        // tout ce qu'il se passe !! 
        // Attention le profiler ne s'affiche QUE si vous avez une balise <body></body> dans la réponse
        $tableau = ["lundi" , "mardi" , "merdredi"];
        dump($tableau , $doctrine);  // => mis dans la barre du profiler 
        // sortir les debug de l'affichage visuel (stocker dans la barre du profiler )
        // composer require profiler debug --dev
        return new Response("<body>accueil</body>");
    }

    #[Route("/article/{id}" , name:"home_article")]
    public function article(ManagerRegistry $doctrine , $id) :Response{

        $article = $doctrine->getManager()->getRepository(Article::class)->find($id);
        
        return $this->render("home/index.html.twig", ["article" => $article]);
    }

    #[Route("/boostwatch")]
    public function boostwatch() : Response{

        return $this->render("home/boostwatch.html.twig");
    }
}