<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Article;
use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index()
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    /**
     * @Route("/commentaire/crea", name="commentairecrea")
     * @Route("/commentaire/edit/{id}", name="editcommentaire")
     */

    public function creaCommentaire(Commentaire $commentaire=null, Request $request,ObjectManager $manager)
    {

        if (is_null($commentaire))
        $commentaire = new Commentaire();

        $formCommentaire = $this->createFormBuilder($commentaire)
                                ->add('Contents')
                                ->add('image')
                                ->add('author', EntityType::class, array(
                                    'class' => Users::class,
                                    'choice_label' => 'Name'))
                                ->add('enregister', SubmitType::class, array('label' => 'creation'))                                    
                                ->getForm();

        $formCommentaire->handleRequest($request);
                                    
        if ($formCommentaire->isSubmitted() && $formCommentaire->isValid()) 
        {                                 

            $commentaire->setDateCreate(new \DateTime());
                                
            $manager->persist($commentaire);
            $manager->flush();
            return $this->redirectToRoute('listcommentaire');
        }

        return $this->render('commentaire/creaCommentaire.html.twig',[
            'form' => $formCommentaire->createView(),
            
 
        ]);


                                

    }

    /**
     * @Route("/commentaire/list", name="listcommentaire")
     */
    public function listCommentaire(CommentaireRepository $repo)
    {
        $allCommentaire =$repo->findAll();
        return $this->render('commentaire/listCommentaire.html.twig',[
            'all'  => $allCommentaire
        ]);

    }

    


    /**
    * @Route("/commentaire/delete/{id}", name="deletecommentaire")
    */ 

    public function delCommentaire(ObjectManager $manager, Commentaire $commentaire)
    {
        $manager->remove($commentaire);
        $manager->flush();
        return $this->redirectToRoute("listcommentaire");  

    }
}
