<?php
namespace App\Controller;

use App\Entity\Author;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AuthorController extends AbstractController {
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    /**
    * @Route("/authors", name="author_list")
    * @Method({"GET"})
    */
    public function index(){
        $authors = $this->doctrine->getRepository(Author::class)->findAll();
        // dd($authors);

        return $this->render('authors/index.html.twig', array('authors' => $authors));
    }


    /**
     * @Route("/author/edit/{id}", name="edit_author")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $author = new Author();
        $author = $this->doctrine->getRepository(Author::class)->find($id);

        $form = $this->createFormBuilder(($author))
            ->add(
                'firstName',
                TextType::class,
                array('attr' => array('class' => 'form-control'))
            )
            ->add(
                'lastName',
                TextType::class,
                array('attr' => array('class' => 'form-control'))
            )
            ->add(
                'notes',
                TextareaType::class,
                array(
                    'attr' => array(
                                'class' => 'form-control',
                                'style' => 'height: 130px',
                                'maxLength' => "255"
                            )
                )
            )

            ->add(
                'save',
                SubmitType::class,
                array(
                    'label' => 'Update',
                    'attr' => array('class' => 'btn btn-primary mt-3')
                )
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('author_list');
        }

        return $this->render(
            'authors/edit.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @Route("/author/delete/{id}")
     * @Method({"DELETE"})
     */
    function delete($id)
    {
        $author = $this->doctrine->getRepository(Author::class)->find($id);

        $entityManager = $this->doctrine->getManager();
        $entityManager->remove($author);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }


    /**
     * @Route("/author/{id}", name="author_show")
     * @Method({"GET"})
     */
    public function show($id)
    {
        $author = $this->doctrine->getRepository(Author::class)->find($id);

        return $this->render('authors/show.html.twig', array('author' => $author));
    }
}
