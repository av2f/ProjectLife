<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MyProfileController extends AbstractController
{
    /**
     * @Route("/myprofile", name="app_myprofile")
     */
    public function index()
    {
        return $this->render('myprofile/index.html.twig', [
            'controller_name' => 'MyProfileController',
        ]);
    }
}
