<?php

namespace App\Controller;

use App\Entity\Mouvies;
use App\Form\MouviesType;
use App\Repository\MouviesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mouvies")
 */
class MouviesController extends AbstractController
{
    /**
     * @Route("/", name="mouvies_index", methods={"GET"})
     */
    public function index(MouviesRepository $mouviesRepository): Response
    {
        $this ->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('mouvies/index.html.twig', [
            'mouvies' => $mouviesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mouvies_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this ->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $mouvy = new Mouvies();
        $form = $this->createForm(MouviesType::class, $mouvy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mouvy);
            $entityManager->flush();

            return $this->redirectToRoute('mouvies_index');
        }

        return $this->render('mouvies/new.html.twig', [
            'mouvy' => $mouvy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mouvies_show", methods={"GET"})
     */
    public function show(Mouvies $mouvy): Response
    {
        $this ->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('mouvies/show.html.twig', [
            'user' => $this->getUser(),
            'mouvy' => $mouvy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mouvies_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mouvies $mouvy): Response
    {
        $this ->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(MouviesType::class, $mouvy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mouvies_index');
        }

        return $this->render('mouvies/edit.html.twig', [
            'mouvy' => $mouvy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mouvies_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Mouvies $mouvy): Response
    {
        $this ->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->isCsrfTokenValid('delete'.$mouvy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mouvy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mouvies_index');
    }

    //contrôler le nombre de mouvies affichés par page
    public function mouvieSortAction($page, MouviesRepository $mouviesRepository)
    {  
        $maxMouvies ='10';
        $em = $this->getDoctrine()->getManager();
        $mouviesCount = $mouviesRepository->countTotal();
        $mouviesOfPage = $mouviesRepository->getListMouvie($page, $maxMouvies);
        $pagination = array(
                'page' => $page,
                'route' => 'mouvie_list',
                'pages_count' => ceil($mouviesCount / $maxMouvies),
                'route_params' => array()
        );

            return $this->render('mouvies/index.html.twig', array(
                'title' => "coucou",
                'mouvies' => $mouviesOfPage,
                'posts_count'=>$mouviesCount,
                'pagination'=> $pagination
                ));
    }
}
