<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController {
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    /**
     * @Route("/books", name="book_list")
     * @Method({"GET"})
     */
    public function index(){
        $books = $this->doctrine->getRepository(Book::class)->findAll();
        return $this->render('books/index.html.twig', array('books' => $books));
    }
}
