<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Picture;

/**
 * @Route("/admin/recette")
 */
class RecetteController extends Controller
{
    public $menu = "recette";
    /**
     * @Route("/", name="recette_index", methods={"GET"})
     */
    public function index(RecetteRepository $recetteRepository): Response
    {
        return $this->render('recette/index.html.twig', [
            'menu' => $this->menu
        ]);
    }

    /**
     * @Route("/new", name="recette_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);

        if (array_key_exists('recette',$request->request->all())) {
            $entityManager = $this->getDoctrine()->getManager();
            $data_recette = $request->request->all()['recette'];
            $data_picture = $request->files->all()['recette']['pictures'];

            $recette->setNom($data_recette['nom']);
            $recette->setEtapes($data_recette['etapes']);
            for ($i=0; $i < count($data_picture); $i++) { 
                $file = $data_picture[$i];
                $picture = new Picture();
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $uploads_directory = $this->getParameter('uploads_directory_recette');
                $file->move(
                    $uploads_directory,
                    $filename
                );
                $picture->setUrl($uploads_directory.'/'.$filename);
                $picture->setName($filename);
                $entityManager->persist($picture);
                $recette->addPicture($picture);
            }
            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('recette_index');
        }

        return $this->render('recette/new.html.twig', [
            'recette' => $recette,
            'form' => $form->createView(),
            'menu' => $this->menu
        ]);
    }

    /**
     * @Route("/{id}", name="recette_show", methods={"GET"})
     */
    public function show(Recette $recette): Response
    {
        return $this->render('recette/show.html.twig', [
            'recette' => $recette,
            'menu' => $this->menu
        ]);
    }

    /**
     * @Route("/{id}/edit", name="recette_edit", methods={"GET","POST"} ,options= { "expose" = true })
     */
    public function edit(Request $request, Recette $recette): Response
    {
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recette_index');
        }

        return $this->render('recette/edit.html.twig', [
            'recette' => $recette,
            'form' => $form->createView(),
            'menu' => $this->menu
        ]);
    }

    /**
     * @Route("/delete/{id}", name="recette_delete", methods={"GET"},options = { "expose" = true })
     */
    public function delete(Request $request, Recette $recette): Response
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recette);
            $entityManager->flush();
            return new JsonResponse();
        } else {
            throw $this->createNotFoundException('Page not found');
        }
    }

    /**
     * @Route("/json/data/{limit}/{offset}/{search}", name="recette_json", options = { "expose" = true })
     */
    public function ajaxGetRecette($limit, $offset, $search = '', RecetteRepository $recetteRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $allRecette = $recetteRepository->customFindByCriter($limit, $offset, $search);
            $numberOfAllRecette = count($recetteRepository->customFindByCriterCount($search));
            foreach ($allRecette as $key => $value) {
                $data[] = [
                    'id' => $value->getId(),
                    'nom' => $value->getNom(),
                    'etapes' => $value->getEtapes(),
                ];
            }
            if (isset($data)) {
                $output['count'] = $numberOfAllRecette;
                $output['data'] = $data;
            } else {
                $output['count'] = [];
                $output['data'] = [];
            }
            return new JsonResponse($output);
        } else {
            throw $this->createNotFoundException('Page not found');
        }
    }
}
