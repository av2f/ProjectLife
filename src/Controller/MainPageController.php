<?php

namespace App\Controller;

use App\Repository\SubscriptionRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainPageController extends AbstractController
{
    /**
     * @Route("/main", name="app_main")
     */
    public function index(SubscriptionRepository $subRepo)
    {
        $user=$this->getUser();
        $subscription = $subRepo -> findOneBy([
            'subscriber' => $user,
            'active' => true,
        ]);
        $test="abonné";
        if (!$user->getSubscribed()) {
            $test="pas abonné";
        }
        return $this->render('main/index.html.twig', [
            'user' => $user,
            'test' => $test,
            'subscription' => $subscription
        ]);
    }
}
