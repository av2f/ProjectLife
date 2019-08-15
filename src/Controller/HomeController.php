<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Gender;
use App\Form\HomeRegisterType;
use App\Repository\GenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * Display home page with management of registry form
     * Author : Frederic Parmentier
     * CreatedAt : 2019/08/06
     * 
     * @Route("/", name="app_home")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, GenderRepository $repo ) {
        $user = new User;

        // Create form
        $form=$this->createForm(HomeRegisterType::class, $user);

        // handle the submit
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()){
            $genderId = $form->get('gender')->getData();
            $gender = new Gender();
            $gender = $repo->find($genderId);
            $user->setGender($gender);

            // encode password
            $password=$passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // store the user
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                '<h4>Félicitations et bienvenue '.$form->get('pseudo')->getData().' !</h4><h5>Vous pouvez désormais vous connecter.</h5>'
            );

            return $this->redirectToRoute('app_login');

        }
        
        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}