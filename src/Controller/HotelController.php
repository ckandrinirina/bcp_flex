<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Picture;
use App\Form\HotelType;
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
    public function new(Request $request): Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        // $form->handleRequest($request);
        
        if (array_key_exists('hotel',$request->request->all())) {
            $entityManager = $this->getDoctrine()->getManager();
            $data_hotel = $request->request->all()['hotel'];
            $data_picture = $request->files->all()['hotel']['pictures'];

            $hotel->setNom($data_hotel['nom']);
            $hotel->setAdress($data_hotel['adress']);
            $hotel->setTelFixe($data_hotel['tel_fixe']);
            $hotel->setTelAutre($data_hotel['tel_autre']);
            $hotel->setEmail($data_hotel['email']);
            $hotel->setSite($data_hotel['site']);
            $hotel->setSpeciality($data_hotel['speciality']);
            if ($data_hotel['price'] != "")
                $hotel->setPrice($data_hotel['price']);
            $hotel->setDescription($data_hotel['description']);
            for ($i=0; $i < count($data_picture); $i++) { 
                $file = $data_picture[$i];
                $picture = new Picture();
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $uploads_directory = $this->getParameter('uploads_directory_hotel');
                $file->move(
                    $uploads_directory,
                    $filename
                );
                $picture->setUrl($uploads_directory.'/'.$filename);
                $picture->setName($filename);
                $entityManager->persist($picture);
                $hotel->addPicture($picture);
            }
            $entityManager->persist($hotel);
            $entityManager->flush();

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
    public function edit(Request $request, Hotel $hotel): Response
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

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
