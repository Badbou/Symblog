<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController

{
    /**
     * @Route("/article/listArticle", name="listArticle")
     */
    public function listArticle(ArticleRepository $repo)
    {
        $allArticle  =$repo->findAll();
        return $this->render('article/listArticle.html.twig',[

            'all'  => $allArticle
        ]);
    }

    
    /**
     * @Route("/article/add", name="addArticle")
     * @Route("/article/edit/{id}", name="editarticle")
     */
    public function creaArticle(Article $article =null, Request $request, ObjectManager $manager)
    {
        if (is_null($article))
            $article = new Article();
        
        
        $formArticle = $this->createFormBuilder($article) // je creer mon formulaire
        ->add('title')
        ->add('content')
        ->add('image')
        ->add('author', EntityType::class, array(
            'class' => Users::class,
            'choice_label' => 'name'))

            
        ->add('categories', EntityType::class, array(
            'class' => Categorie::class,
            'choice_label' => 'Name',
            'multiple' => true,
            'expanded' => true
        ))
        ->getForm();


            

        $formArticle->handleRequest($request);
        dump($request);
        dump($article);
        if ($formArticle->isSubmitted() && $formArticle->isValid()) {
            $article->setCreatedDate(new \DateTime());

            $manager->persist($article);
            $manager->flush();
            //return $this->redirectToRoute('listArticle');
        }


        return $this->render('article/addArticle.html.twig',[
            'form' => $formArticle->createView(),
        ]);

    }

    /**
    * @Route("/article/delete/{id}", name="deletearticle")
    */ 
    public function delete(ObjectManager $manager, Article $article) {
        $manager->remove($article);
        $manager->flush();
        return $this->redirectToRoute("listArticle");  
    }

    /**
    * @Route("/article/view/{id}", name="viewarticle")
    */ 
    public function view(Article $article=null, ObjectManager $manager,ArticleRepository $repo, Request $request)
        {

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
            $commentaire->setArticle($article);
            $commentaire->setDateCreate(new \DateTime());
                                
            $manager->persist($commentaire);
            $manager->flush();
            //return $this->render('creaCommentaire.html.twig');
        }


        return $this->render('article/viewArticle.html.twig',[
            'form' => $formCommentaire->createView(),
            'article'  => $article
        ]);
    }

}
