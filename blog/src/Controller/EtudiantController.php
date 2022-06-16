<?php 

namespace App\Controller ;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController{

    #[Route("/new_etudiant" , name:"etudiant_new")]
    public function creer_etudiant(Request $request , ManagerRegistry $doctrine) : Response{

        $etudiant = (new Etudiant())
                        ->setNom("malik")
                        ->setAge(32)
                        ->setAdresse("75 rue de paris")
                        ->setEtat(true)
                        ->setEmail("yahoo@yahoo.fr")
                        ->setTelephone("010101010101")
                        ->setDateNaissance(new \DateTime("2022-12-01"));
        $form = $this->createForm(EtudiantType::class, $etudiant);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($etudiant);
            $em->flush();
            $this->addFlash("m" , "ok");
            return $this->redirectToRoute("etudiant_new");
        }

        return $this->render("etudiant/new.html.twig" , ["form" => $form->createView()]);
    }

}