<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExoContollerController extends AbstractController
{
    #[Route('/exo/contoller', name: 'app_exo_contoller')]
    public function index(): Response
    {
        return $this->render('exo_contoller/index.html.twig', [
            'controller_name' => 'ExoContollerController',
        ]);
    }
    #[Route('/voitures', name: 'voitures')]
    public function voitures(): Response
    {
        return $this->render('/exo_contoller/voitures.html.twig', ["voiture" => "R5", "description" => "une belle voiture noir tu connais bien cher", "prix" => 30000]);
    }

    #[Route('/voitures/list', name: 'listeVoiture')]
    public function listVoiture(VoitureRepository $req ) 
    {
        $a = rand(100,1000);
        $voitures = $req->findAll();
        return $this->render('exo_contoller/list.html.twig', [
            'voitures' => $voitures, "rand" => $a
        ]);
    }

    #[Route("/voitures/new", name:"voiture_create")]
    #[Route("/voitures/edit/{id}", name:"voiture_edit")]
    public function form(Request $globals, EntityManagerInterface $manager, Voiture $voiture= null)
    {
        
        if($voiture ==null):
            $voiture = new Voiture;
        endif;


        $form= $this->createForm(VoitureType::class, $voiture );

        $form->handleRequest($globals);



        dump($voiture);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($voiture);
            $manager->flush();
            return $this->redirectToRoute('listeVoiture');
        }

        return $this->renderForm("exo_contoller/form.html.twig", [
            "formVoiture" => $form,
            "editMode" => $voiture->getId() !== null
        ]);

    }
    #[Route("/voitures/delete/{id}", name:"voiture_delete")]
    public function delete($id, EntityManagerInterface $manager, VoitureRepository $repo)
    {
        $voiture= $repo->find($id);

        $manager->remove($voiture);
        $manager->flush();
        return $this->redirectToRoute('listeVoiture');
    }
    




}
