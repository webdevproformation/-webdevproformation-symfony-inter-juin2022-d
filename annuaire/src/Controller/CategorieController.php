<?php 

namespace App\Controller ;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/categorie")]
class CategorieController extends AbstractController{

    #[Route("/new" , name:"categorie_new")]
    public function new(Request $request , ManagerRegistry $doctrine ) :Response {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute("categorie_new");
        }

        return $this->render("categorie/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

}