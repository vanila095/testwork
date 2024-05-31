<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Orders;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class TestController extends AbstractController
{
    
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    #[Route('/', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    
    #[Route('/app/form', name: 'app_testform')]
    public function testForm(Request $request): Response
    {
       $post = new Orders();
       $form = $this->createForm(OrderType::class, $post);
       $form->handleRequest($request);
       
       $add_ok = 0;
       //отправляем форму
       if ($form->isSubmitted() && $form->isValid()) {
           
           
           $em =  $this->doctrine->getManager();
           $em->persist($post);
           $em->flush();
              
           //перенаправляем на туже страницу c get параметром
           return $this->redirectToRoute('app_testform', ['add' => 'ok']);
       }
       
       if ($request->query->get('add') === 'ok'){
           $add_ok = 1;
       }
       
       return $this->render('test/form.html.twig', [
           'form' => $form->createView(), 
           'add_ok' => $add_ok,
       ]);
       
    }
    
    
    #[Route('/user_add', name: 'user_add')]
    public function createUserAction(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager) {
        
        $user = new User();
        

        $user->setEmail('test@test.ru');
       $user->setPassword(
       $userPasswordHasher->hashPassword(
               $user,
               'test'
           )
       );
        
       $entityManager->persist($user);
       $entityManager->flush();
    }

}
