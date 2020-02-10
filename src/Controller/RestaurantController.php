<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("admin/restaurant")
 */
class RestaurantController extends Controller
{
    public $menu = 'restaurant';
    /**
     * @Route("/", name="restaurant_index", methods={"GET"})
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'menu'=>$this->menu
        ]);
    }

    /**
     * @Route("/new", name="restaurant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('restaurant_index');
        }

        return $this->render('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
            'menu'=>$this->menu
        ]);
    }

    /**
     * @Route("/{id}", name="restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
            'menu'=>$this->menu
        ]);
    }

    /**
     * @Route("/{id}/edit", name="restaurant_edit", methods={"GET","POST"},options={"expose"=true})
     */
    public function edit(Request $request, Restaurant $restaurant): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('restaurant_index');
        }

        return $this->render('restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
            'menu'=>$this->menu
        ]);
    }

    /**
     * @Route("/delete/{id}", name="restaurant_delete", methods={"GET"},options={"expose"=true})
     */
    public function delete(Request $request, Restaurant $restaurant): Response
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($restaurant);
            $entityManager->flush();
            return new JsonResponse();
        } else {
            throw $this->createNotFoundException('Page not found');
        }
    }

    /**
     * @Route("/json/data/{limit}/{offset}/{search}", name="restaurant_json", options = { "expose" = true })
     */
    public function ajaxGetEvent($limit, $offset, $search = '', RestaurantRepository $restaurantRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $allrestaurant = $restaurantRepository->customFindByCriter($limit, $offset, $search);
            $numberOfAllrestaurant = count($restaurantRepository->customFindByCriterCount($search));
            foreach ($allrestaurant as $key => $value) {
                $data[] = [
                    'id' => $value->getId(),
                    'nom' => $value->getNom(),
                    'adresse' => $value->getAdress(),
                    'description' => $value->getDescription(),
                    'Email' => $value->getEmail(),
                    'Price' => $value->getPrice(),
                    'Site' => $value->getSite(),
                    'Specialite' => $value->getSpeciality(),
                    'Tel autres' => $value->getTelAutre(),
                    'Tel Fixe' => $value->getTelFixe(),
                    'Visibilite' => $value->getViewers()
                ];
            }
            if (isset($data)) {
                $output['count'] = $numberOfAllrestaurant;
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
