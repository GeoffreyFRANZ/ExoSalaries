<?php

namespace App\Controller;

use App\Entity\Salarie;
use App\Entity\Entreprise;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/salaries")
 */
class SalarieController extends AbstractController
{





    /**
     * @Route("/add", name="salarie_add")
     * @Route("/{id}/edit", name="salarie_edit")
     */




    public function addSalarie(Salarie $salarie =  null, Request $request, EntityManagerInterface $manager)
    {

        if (!$salarie) {
            $salarie = new Salarie();
        }
        $form  = $this->createFormBuilder($salarie)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('datenaissance', DateType::class, [
                'years' =>  range(date('Y'), date('Y') - 70),
                'label' => 'Date de naissance',
                'format' => 'ddMMyyyy'
            ])
            ->add('adresse', TextType::class)
            ->add('cp', TextType::class)
            ->add('ville', TextType::class)
            ->add('dateEmbauche', dateType::class, [
                'years' =>  range(date('Y'), date('Y') - 70),
                'label' => 'Date d\'embauche',
                'format' => 'ddMMyyyy'
            ])
            ->add('Entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'raisonSocial',
            ])
            ->add('Valider', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($salarie);
            $manager->flush();

            return $this->redirectToRoute('salarie');
        }

        return $this->render('salarie/add_edit.html.twig', [
            'form' => $form->createView(),
            'editMode' => $salarie->getId() !== null

        ]);
    }
    /**
     * @Route("/", name="salarie")
     */
    public function index(): Response
    {
        $salaries = $this->getDoctrine()->getRepository(Salarie::class)->findAll();


        return $this->render('salarie/index.html.twig', [
            'salaries' => $salaries,
        ]);
    }
    /**
     * @Route("/{id}", name="salarie_show", methods="GET" )
     */

    public function show(Salarie $salarie): Response
    {

        $entreprise  =  new Entreprise();


      $collegues =  $salarie->getCollegues($entreprise);
    

        return $this->render('salarie/show.html.twig', ['salarie' => $salarie, 'collegues' => $collegues]);
    }

    /**
     * @Route("/{id}/delete" , name="salarie_delete")
     */

    public function delete(Salarie $salarie,  EntityManagerInterface $em)
    {
        $em->remove($salarie);
        $em->flush();

        return $this->render('salarie');
    }
}
