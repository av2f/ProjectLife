<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainPageController extends AbstractController
{
    /**
     * @Route("/main", name="app_main")
     */
    public function index()
    {
        $user=$this->getUser();
        return $this->render('main/index.html.twig', [
            'user' => $user
        ]);
    }
}
