<?php
namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/article/{id}", name="article_show")
     * @Method({"GET"})
     */
    public function show(int $id){
        $article = $this->doctrine->getRepository(Article::class)->find($id);

        return $this->render('articles/show.html.twig', array('article' => $article));
    }

    /**
     * @Route("/article/save")
     * @Method({"POST"})
     */
    public function save(): Response{
        $entityManager = $this->doctrine->getManager();

        $input = array('Non Music', 'Soul', 'Sokoke', 'Chausie', 'Dusky Dolphin','American Curl','British Shorthair');
        $input2 = array('Miniature Horse','Cory\'s Shearwater','Gulf menhaden','Siamese Crocodile','Beddome\'s cat snake');
        $key1 = array_rand($input, 1);
        $key2 = array_rand($input2, 1);
        $article = new Article();
        $article->setTitle($input[$key1]);
        $article->setBody($input2[$key2]);

        // tell Doctrine you want to (eventually) save the Article (no queries yet)
        $entityManager->persist($article);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $article->getId());

    }
}
