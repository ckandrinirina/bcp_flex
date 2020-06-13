<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Etablissement;
use App\Manager\ServiceManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    private $oManager;
    
    public function __construct(ServiceManager $oManager) {
        $this->oManager = $oManager;
    }
    
    /**
     * @Route("/", name="home")
     */
    public function homeAction(Request $oRequest) {
        return $this->render('Etablissement/home.html.twig');
    }
    
    /**
     * @param Request $oRequest
     * @Route("/etablissement/hotel", name="hotel")
     * @Route("/search/hotel", name="hotel_search")
     * @Route("/search/restorant", name="restorant_search")
     * @Route("/etablissement/restorant", name="restorant")
     */
    public function etablissementAction(Request $oRequest) {
        $sRoute = $oRequest->get('_route');
        $oSession = $this->get('session');
        $aParam = $oSession->get('aSearchParam');
        $aItems = $oSession->get('aSearchResult');
        $oPaginationItem = null;
        $sType = $aParam['type'];
        if ($sRoute != 'restorant_search' && $sRoute != 'hotel_search') {
            $queryEtablissement = $this->oManager->getEtablissement($sRoute);
            $oPagination = $this->container->get('knp_paginator');
            $oPaginationItem = $oPagination->paginate($queryEtablissement, $oRequest->query->getInt('page', 1), 12);
            if ($sRoute != $aParam['type']) {
                $oPaginationItem->setItems($this->oManager->generateStarEtablissementsOfArray([]));
                $aItems = $oPaginationItem;
            }
            
            $oPaginationItem->setItems($this->oManager->generateStarEtablissementsOfArray($oPaginationItem->getItems()));
            $sType = $sRoute;
        }
        return $this->render('Etablissement/etablissement.html.twig', array(
            'items' => $aItems,
            'defaultItems' => $oPaginationItem,
            'type' => $sType
        ));
    }
    
    /**
     * @Route("/recette", name="recette")
     */
    public function recetteAction() {
        return $this->render('Etablissement/recette.html.twig');
    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $oRequest) {
        if ($oRequest->isMethod('POST')) {
            $params = $oRequest->request->all();
            $sendTo = $this->getParameter('owner_email');
            if ($this->oManager->sendMail($sendTo, $params['name'], $params['email'], $params['subject'], $params['message'])) {
                return new \Symfony\Component\HttpFoundation\JsonResponse('mail envoyee');
            }
        }
        return $this->render('Etablissement/contact.html.twig');
    }
    
    /**
     * @param type $id
     * @Route("/etablissement/fiche/{id}", name="fiche")
     */
    public function ficheAction(Etablissement $oEtablissement) {
        $aoEtablissement = $this->oManager->generateStarEtablissementsOfArray([$oEtablissement]);
        $oEtablissement->setViewers($oEtablissement->getViewers() + 1);
        $this->oManager->crudObject($oEtablissement, 'update');
        return $this->render('@App-/Etablissement/fiche.html.twig', ['etablissement' => $aoEtablissement[0]]);
    }
    
    /**
     * 
     * @param type $param
     * @Route("/search", name="search_etablissament")
     */
    public function searchEtablissement(Request $oRequest) {
        $aParam = $oRequest->request->all();
        $oSession = $this->get('session');
        if (empty($aParam)) {
            $aParam = $oSession->get('aSearchParam');
        }
        $queryEtablissement = $this->oManager->searchEtablissement($aParam);
        $paginator = $this->container->get('knp_paginator');
        $oPagination = $paginator->paginate($queryEtablissement, $oRequest->query->getInt('page', 1), 12);
        $oPagination->setItems($this->oManager->generateStarEtablissementsOfArray($oPagination->getItems()));
        $oSession->set('aSearchParam', $aParam);
        $oSession->set('aSearchResult', $oPagination);
        $sRoute = ($aParam['type'] == 'hotel') ?  'hotel_search' : 'restorant_search';
        return $this->redirectToRoute($sRoute);
    }
}
