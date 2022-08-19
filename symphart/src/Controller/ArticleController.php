<?php
namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController {
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("/", name="article_list")
     * @Method({"GET"})
     */
    public function index(){
        /*
            route via config.
            add:
                use Symfony\Component\HttpFoundation\Response;

            config/routes/routes.yaml
            return new Response('<html><body>Hello</body></html>');
        */

        $articles = $this->doctrine->getRepository(Article::class)->findAll();
        /* routing via annotation */
        return $this->render('articles/index.html.twig', array('articles' => $articles));
    }

    /**
     * @Route("/article/new", name="new_article")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request){
        $article = new Article();

        $form = $this->createFormBuilder(($article))
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('body', TextareaType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
            $article = $form->getData();

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render(
            'articles/new.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @Route("/article/edit/{id}", name="edit_article")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $article = new Article();
        $article = $this->doctrine->getRepository(Article::class)->find($id);

        $form = $this->createFormBuilder(($article))
            ->add(
                'title', TextType::class,
                array('attr' => array('class' => 'form-control')))
            ->add(
                'body', TextareaType::class,
                array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add(
                'save', SubmitType::class, array('label' => 'Save',
                'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render(
            'articles/edit.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @Route("/article/delete/{id}")
     * @Method({"DELETE"})
     */
    function delete(Request $request, $id){
        $article = $this->doctrine->getRepository(Article::class)->find($id);

        $entityManager = $this->doctrine->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }

    /**
     * @Route("/article/{id}", name="article_show")
     * @Method({"GET"})
     */
    public function show($id)
    {
        $article = $this->doctrine->getRepository(Article::class)->find($id);

        return $this->render('articles/show.html.twig', array('article' => $article));
    }


}
