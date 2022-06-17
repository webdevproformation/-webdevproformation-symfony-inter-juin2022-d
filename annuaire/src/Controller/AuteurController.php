<?php 

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Image;
use App\Form\AuteurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// préfixe de route 
#[Route("/auteur")]
class AuteurController extends AbstractController{
    #[Route("/new" , name:"auteur_new")] // /auteur/new
    public function new(Request $request , ManagerRegistry $doctrine): Response {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class , $auteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $request->files->get("auteur")["photo_profil"];
            $ou = $this->getParameter("upload_directory");
            $nom_fichier = md5(uniqid()) . "." . $file->guessExtension();
            $file->move( $ou , $nom_fichier);

            $image = new Image();
            $image->setUrl($nom_fichier);

            $auteur->setImage($image);

            $em = $doctrine->getManager();
            $em->persist($auteur);
            $em->flush();
            return $this->redirectToRoute("auteur_new");
        }
        return $this->render("auteur/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

}