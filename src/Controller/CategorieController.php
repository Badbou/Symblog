<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index()
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("/categorie/crea", name="creacategorie")
     * @Route("/categorie/edit/{id}", name="editcategorie")
     */
    public function creaCategorie(Categorie $categorie=null, Request $request,ObjectManager $manager)
    {
        if (is_null($categorie))
        $categorie = new Categorie();
        $formCategorie = $this->createFormBuilder($categorie)
        ->add('name')
        ->add('enregister', SubmitType::class, array('label' => 'creation'))                                    
        ->getForm();

        $formCategorie->handleRequest($request);
                                    
        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) 
        {                           
                                         
            $manager->persist($categorie);
            $manager->flush();
            return $this->redirectToRoute('listcategorie');
        }

        return $this->render('categorie/creaCategorie.html.twig',[
            'form' => $formCategorie->createView(),
            
 
        ]);


    }

    /**
     * @Route("/categorie/list", name="listcategorie")
     */
    public function listCategorie(CategorieRepository  $repo)
    {
        $allCategorie =$repo->findAll();
        return $this->render('categorie/listCategorie.html.twig',[
            'all'  => $allCategorie
        ]);

    }


    public function editCategorie()
    {

    }

    /**
    * @Route("/categorie/delete/{id}", name="deletecategorie")
    */ 
    public function delCategorie(ObjectManager $manager, Categorie $categorie)
    {
        $manager->remove($categorie);
        $manager->flush();
        return $this->redirectToRoute("listcategorie");  

    }
}
