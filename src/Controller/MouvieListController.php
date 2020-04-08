<?php

namespace App\Controller;

use App\Entity\MouvieList;
use App\Entity\Mouvies;
use App\Form\MouvieListType;
use App\Repository\MouvieListRepository;
use App\Repository\MouviesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mouvie/list")
 */
class MouvieListController extends AbstractController
{
    /**
     * @Route("/", name="mouvie_list_index", methods={"GET"})
     */
    public function index(MouvieListRepository $mouvieListRepository): Response
    {
        return $this->render('mouvie_list/index.html.twig', [
            'mouvie_lists' => $mouvieListRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mouvie_list_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $mouvieList = new MouvieList();
        $form = $this->createForm(MouvieListType::class, $mouvieList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $mouvieList->setUser($this->getUser());
            $entityManager->persist($mouvieList);
            $entityManager->flush();

            return $this->redirectToRoute('mouvie_list_index');
        }

        return $this->render('mouvie_list/new.html.twig', [
            'mouvie_list' => $mouvieList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mouvie_list_show", methods={"GET"})
     */
    public function show(MouvieList $mouvieList): Response
    {
        return $this->render('mouvie_list/show.html.twig', [
            'mouvie_list' => $mouvieList,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mouvie_list_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MouvieList $mouvieList): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(MouvieListType::class, $mouvieList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mouvie_list_index');
        }

        return $this->render('mouvie_list/edit.html.twig', [
            'mouvie_list' => $mouvieList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mouvie_list_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MouvieList $mouvieList): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mouvieList->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mouvieList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mouvie_list_index');
    }

    public function addToMouvieList(Request $request, $id, $idMouvie , MouvieListRepository $mouvieListRepository , MouviesRepository $mouviesRepository){
        $mouvieList = $mouvieListRepository->find($id);
        $mouvie = $mouviesRepository->find($idMouvie);
        $mouvieList->addMouvy($mouvie);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($mouvieList);
        $entityManager->flush();
        return $this->redirectToRoute('mouvie_list_index');
    }
}
