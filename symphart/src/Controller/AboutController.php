<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AboutController extends AbstractController {

    /**
     * @Route("/about", name="about")
     * @Method({"GET", "POST"})
     */
    public function about(): Response{
        return $this->render('about/index.html.twig', array());
    }
}
