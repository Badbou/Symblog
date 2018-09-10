<?php

namespace App\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Entity\Task;


use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'test1' => 'test2'
        ]);
    }




    /**
    * @Route("/users/{id}", name="detailsuser", requirements={"id"="\d+"})
    */

    public function utilisateur(UsersRepository $repo, $id){

        
        $user = $repo->findOneById($id);       
        
        return $this->render('users/detailsUsers.html.twig',[
            'user' => $user
        ]);
    }







    /**
    * @Route("/users/list", name="listusers")
    */
    public function liste(UsersRepository $repo)
    {
       
        $allo =$repo->findAll();
        return $this->render('users/listUsers.html.twig',[

            'all'  => $allo
        ]);


    }

    
    // public function liste()
    // {
    //     $repo = $this->getDoctrine()->getRepository(Users::class);
    //     $allo=$repo->findAll();
    //     $test = $repo->findOneById(5);
    //     $test8 = $repo->findOneByName('name4');
    //     return $this->render('users/listUsers.html.twig',[
    //         'test1' => $test,
    //         'test2' => $test8,
    //         'tous'  => $allo
    //     ]);


    // }




    /**
    *
    * @Route("/users/add", name="adduser")
    * @Route("/users/edit/{id}", name="edituser")
    */
    public function creat(Users $user=null, Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder)
    {

        if (is_null($user))
            $user = new Users();

        $formUser = $this->createFormBuilder($user)
                         ->add('name',TextType::class)
                         ->add('lastName',TextType::class)
                         ->add('email',EmailType::class)
                         ->add('password',RepeatedType::class, array(
                            'type' => PasswordType::class,
                            'first_options'  => array('label' => 'Password'),
                            'second_options' => array('label' => 'Repeat Password'),))                        

                         ->add('enregister', SubmitType::class, array('label' => 'creation'))
                         
                         ->getForm();

        
        


        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {
      
            $user->setdateCreate(new \DateTime());
            $user->setdateLastLogin(new \DateTime());
            
            
            $password =$encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            //$user = $formUser->getData();  
    
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('listusers');
        }
      
        return $this->render('users/adduser.html.twig',[
            'form' => $formUser->createView(),
            
 
        ]);


    }

    /**
     * @Route("/users/delete/{id}", name="deleteuser")
    */ 
    public function delete(ObjectManager $manager, Users $user) {
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute("listusers");  
    }


    
}
