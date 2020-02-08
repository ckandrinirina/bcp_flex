<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends Controller
{
    public $menu = 'event';
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'menu'=>$this->menu
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'menu'=>$this->menu
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
            'menu'=>$this->menu
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"}, options = { "expose" = true })
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'menu'=>$this->menu
        ]);
    }

    /**
     * @Route("/delete/{id}", name="event_delete", methods={"GET"},options = { "expose" = true })
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
    
            return new JsonResponse();
        } else {
            throw $this->createNotFoundException('Page not found');
        }
    }

    /**
     * @Route("/json/data/{limit}/{offset}/{search}", name="event_json", options = { "expose" = true })
     */
    public function ajaxGetEvent($limit, $offset, $search = '', EventRepository $eventRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $allEvent = $eventRepository->customFindByCriter($limit, $offset, $search);
            $numberOfAllEvent = count($eventRepository->customFindByCriterCount($search));
            foreach ($allEvent as $key => $value) {
                $data[] = [
                    'id' => $value->getId(),
                    'nom' => $value->getNom(),
                    'presentation' => $value->getPresentation(),
                    'date' => $value->getDate()->format('d-m-Y'),
                    'place' => $value->getPlace(),
                ];
            }
            if (isset($data)) {
                $output['count'] = $numberOfAllEvent;
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
