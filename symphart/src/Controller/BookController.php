<?php
// src/Controller/BookController.php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
//use for routes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

// form controls
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

// request, response
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class BookController extends AbstractController {
    // registry manager
    private $manager_registry;
    private $bookRepository;
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        ManagerRegistry $manager_registry,
        BookRepository $bookRepository
    )
    {
        $this->manager_registry = $manager_registry;
        $this->bookRepository = $bookRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/books", name="books_list")
     */
    public function list(){
        $books = $this->entityManager->getRepository(Book::class)->findAll();
        return $this->render('books/index.html.twig', array('books' => $books));
    }

    /**
     * @Route("/book/edit/", name="book_edit")
     */
    public function edit(Request $request, int $id){
        dd($request);
    }

    /**
     * @Route("/book/{id}", name="book_show")
     */
    public function show(Request $request, int $id): Response
    {
        $book = $this->manager_registry->getRepository(Book::class)->find($id);
        $authors = $this->bookRepository->findAuthorsByBook($id);

        return $this->render('books/show.html.twig', array('book' => $book, 'authors' => $authors));
    }

    /**
     * @Route("/book/delete/", name="book_delete")
     */
    public function delete(Request $request, int $id)
    {
        dd($request);
    }

    /**
     * @Route("/book/new/", name="book_new")
     */
    public function new()
    {
        dd(array());
    }

}
