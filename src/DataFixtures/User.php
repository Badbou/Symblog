<?php

namespace App\DataFixtures;


use App\Entity\Users;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class User extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 3 ; $i++) { 
            $user = new Users();
            
            $user->setName('user'.$i)
                ->setLastName('tg'.$i)
                ->setEmail('user@tg.fr')
                ->setPassword('tg')
                ->setDateCreate(new \DateTime())
                ->setDateLastLogin(new \DateTime());

            $manager->persist($user);



            for ($l=1; $l < 2 ; $l++) { 
                $category = new Categorie();
                
                $category->setName('catégorie de user'.$i);
                    
    
                $manager->persist($category);




                for ($j=1; $j < 2 ; $j++) { 
                    $article = new Article();
                    
                    $article->setTitle('article n°'.$j)
                         ->setAuthor($user)
                         ->setImage('http://via.placeholder.com/100x100')
                         ->addCategory($category)
                         ->setContent('contenu de l\'article')
                         ->setCreatedDate(new \DateTime());
                       
                    $manager->persist($article);
    


                    for ($k=1; $k < 2 ; $k++) { 
                        $comment = new Commentaire();
                    
                         $comment->setContents('contenu du commentaire')
                         ->setAuthor($user)
                         ->setArticle($article)
                         
                         ->setDateCreate(new \DateTime());
    
                         $manager->persist($comment);
                    }
                }    
           
            }
        }
        $manager->flush();
    }
}
