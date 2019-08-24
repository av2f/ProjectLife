<?php

namespace App\Controller;

use App\Repository\SubscriptionRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MainPageController extends AbstractController
{
    /**
     * display the main page
     *
     * @Route("/main", name="btj_main")
     * 
     * Can access only if login ok
     * @isGranted("ROLE_USER")
     *
     * @param SubscriptionRepository $subRepo
     * @return void
     */
    public function index(SubscriptionRepository $subRepo)
    {
        $user=$this->getUser();
        return $this->render('main/index.html.twig', [
            'user' => $user,
            // retrieve the last subscription / null if never subscription
            'subscription' => $subRepo -> findLastSubscription($user)
        ]);
    }
}
