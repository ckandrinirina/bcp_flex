<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Picture;
use App\Form\HotelType;
use App\Manager\Hotel\HotelManager;
use App\Repository\HotelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/hotel")
 */
class HotelController extends Controller
{
    public $menu = 'hotel';
    /**
     * @Route("/", name="hotel_index", methods={"GET"})
     */
    public function index(HotelRepository $hotelRepository): Response
    {
        return $this->render('hotel/index.html.twig', [
            'menu' => $this->menu
        ]);
    }

    /**
     * @Route("/new", name="hotel_new", methods={"GET","POST"})
     */
    public function new(Request $request,HotelManager $hotelManager): Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        // $form->handleRequest($request);
        
        if (array_key_exists('hotel',$request->request->all())) {
            $hotelManager->saveHotelFromAjax($request,$hotel);
            return $this->redirectToRoute('hotel_index');
        }

        return $this->render('hotel/new.html.twig', [
            'hotel' => $hotel,
            'form' => $form->createView(),
            'menu' => $this->menu
        ]);
    }

    /**
     * @Route("/{id}", name="hotel_show", methods={"GET"})
     */
    public function show(Hotel $hotel): Response
    {
        return $this->render('hotel/show.html.twig', [
            'hotel' => $hotel,
            'menu' => $this->menu
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hotel_edit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function edit(Request $request, Hotel $hotel, HotelManager $hotelManager): Response
    {
        $form = $this->createForm(HotelType::class, $hotel);

        if (array_key_exists('hotel', $request->request->all())) {
            $hotelManager->saveHotelFromAjax($request, $hotel);
            return $this->redirectToRoute('hotel_index');
        }

        return $this->render('hotel/edit.html.twig', [
            'hotel' => $hotel,
            'form' => $form->createView(),
            'menu' => $this->menu
        ]);
    }

    /**
     * @Route("/delete/{id}", name="hotel_delete", methods={"GET"},options={"expose"=true})
     */
    public function delete(Request $request, Hotel $hotel): Response
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hotel);
            $entityManager->flush();
            return new JsonResponse();
        } else {
            throw $this->createNotFoundException('Page not found');
        }
    }

     /**
     * @Route("/json/data/{limit}/{offset}/{search}", name="hotel_json", options = { "expose" = true })
     */
    public function ajaxGetEvent($limit, $offset, $search = '', HotelRepository $hotelRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $allHotel = $hotelRepository->customFindByCriter($limit, $offset, $search);
            $numberOfAllHotel = count($hotelRepository->customFindByCriterCount($search));
            foreach ($allHotel as $key => $value) {
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
                $output['count'] = $numberOfAllHotel;
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
