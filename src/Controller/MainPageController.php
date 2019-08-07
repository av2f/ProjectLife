<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainPageController extends AbstractController
{
    /**
     * @Route("/mainpage", name="app_mainpage")
     */
    public function index()
    {
        $user=$this->getUser();
        return $this->render('mainpage/index.html.twig', [
            'user' => $user
        ]);
    }
}
