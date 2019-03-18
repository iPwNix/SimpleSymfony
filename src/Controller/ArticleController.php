<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\GreetingGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     * @Method({"GET"})
     */
    public function index(GreetingGenerator $greetingGenerator)
    {

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'greeting' => $greetingGenerator->getRandomGreeting()
        ]);
    }

    /**
     * @Route("/articles/new", name="new_article")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form    = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('articles');
        }

        return $this->render('article/new.html.twig', [
            'article_form' => $form->createView(),
        ]);

    }


    /**
     * @Route("/articles/edit/{id}", name="edit_article")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('article_show', ['id' => $id]);
        }

        return $this->render('article/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("articles/ajax")
     * @Method({"POST"})
     */
    public function ajax_test(Request $request)
    {
        $data = json_decode($request->getContent());

        if ($data->input) {
            return new JsonResponse(["response" => $data->input]);
        } else {
            return new JsonResponse(["response" => "Input Empty"]);
        }
    }

    /**
     * @Route("/articles/{id}", name="article_show")
     */
    public function show($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        return $this->render('article/show.html.twig', array('article' => $article));
    }

    /**
     * @Route("/articles/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('articles');
    }
}
