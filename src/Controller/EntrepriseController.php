<?php


namespace App\Controller;

use App\Entity\Salarie;
use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\SalarieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("entreprises")
 */


class EntrepriseController extends AbstractController
{
    /**
     * @Route("/{id}/delete" , name="entreprise_delete", methods="GET")
     */


    public function delete(Entreprise $entreprise,  EntityManagerInterface $em)
    {

        $salarie = $entreprise->getSalaries()->getIterator();
        foreach ($salarie as $sal) {

            $em->remove($sal);
            $em->flush();
        }

        $em->remove($entreprise);
        $em->flush();

        return $this->redirectToRoute('entreprise');
    }
    /**
     * @Route("/add", name="entreprises_add")
     * @Route("/{id}/edit", name="entreprise_edit")
     */

    public function addEdit(Entreprise $entreprise =  null, Request $request, EntityManagerInterface $manager)
    {


        if (!$entreprise) {

            $entreprise = new Entreprise();
        }

        $form =  $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('entreprise');
        }

        return $this->render('entreprise/add_edit.html.twig', [

            'formEntreprise' => $form->createView(),
            'editMode' => $entreprise->getId() !== null,
            'entreprise' => $entreprise->getRaisonSocial()
        ]);
    }


    /**
     * @Route("/", name="entreprise")
     */
    public function index(): Response
    {
        $entreprises = $this->getDoctrine()->getRepository(Entreprise::class)->findAll();


        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }


    /**
     * @Route("/{id}", name="entreprise_show" )
     */
    public function show(Entreprise $entreprise)
    {
          
     

        $salarie = $entreprise->getSalaries()->getIterator();
        
        return $this->render('entreprise/show.html.twig', ['entreprise' => $entreprise, 'salaries' => $salarie]);
    }
}
