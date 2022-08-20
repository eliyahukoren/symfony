<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


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

    /**
     * @Route("/book/new", name="new_book")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $book = new Book();

        $form = $this->createFormBuilder(($book))
            ->add(
                'name',
                TextType::class,
                array('attr' => array('class' => 'form-control'))
            )
            ->add(
                'book_description',
                TextareaType::class,
                array('attr' => array('class' => 'form-control'))
            )
            ->add(
                'author_id', ChoiceType::class,
                array(
                    'attr' => array('class' => 'form-select'),
                    'choices' => array('Author 1' => 1, 'Author 2' => 2))
            )
            ->add(
                'publish_date', DateType::class,
                array(
                    'attr' => array('class' => 'form-control js-datepicker form-select'),
                    'widget' => 'choice',
                    'format' => 'yyyy-MM-dd'
                )
            )
            ->add(
                'book_image',
                TextType::class,
                array('attr' => array('class' => 'form-control'))
            )
            ->add(
                'save',
                SubmitType::class,
                array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary mt-3'))
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('book_list');
        }

        return $this->render(
            'books/new.html.twig',
            array('form' => $form->createView())
        );
    }

}
