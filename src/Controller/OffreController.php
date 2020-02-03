<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Photo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Etablissement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Offre controller.
 *
 * @Route("admin/offre")
 */
class OffreController extends Controller
{
    private $oManager;
    
    public function __construct() {
        $this->oManager = $this->container->get('service.manager');
    }
    
    /**
     * Lists all offre entities.
     *
     * @Route("/", name="admin_offre_index",methods={"GET"})
     */
    public function indexAction(Request $oRequest){
        $oEm = $this->getDoctrine()->getManager();
        $oPaginator = $this->container->get('knp_paginator');
        $oQuery = $oEm->getRepository('App:Offre')->listAll();
        $aoOffres = $oPaginator->paginate(
            $oQuery, // query NOT result 
            $oRequest->query->getInt('page', 1), // page number,
            2 // limit per page
        );
        return $this->render('admin/offre/index.html.twig', array(
            'offres' => $aoOffres,
        ));
    }

    /**
     * Creates a new offre entity.
     *
     * @Route("/{id}/new", name="admin_offre_new",methods={"GET","POST"})
     */
    public function newAction(Request $oRequest, Etablissement $oEtablissement) {
        if ($oRequest->getMethod() == 'POST'){
            $sDir = $this->getParameter('path_uploads');
            $oFile = $oRequest->files->get('App_offre')['file'];
            $aRequestContent = $oRequest->request->all();
            if ($oFile instanceof UploadedFile && !empty($aRequestContent) && key_exists('App_offre', $aRequestContent)){
                $oOffre = new Offre();
                $oPhoto = new Photo($oFile, $sDir);
                $oPhoto->setOffre($oOffre);
                $oPhoto->setType('offre');
                $oDataManager = $this->get('liip_imagine.data.manager');
                $oFilterManager = $this->get('liip_imagine.filter.manager');
                $result = $oPhoto->createThumb($oDataManager, $oFilterManager);
                $oOffre->setNom($aRequestContent['App_offre']['nom']);
                $oOffre->setPrix($aRequestContent['App_offre']['prix']);
                $oOffre->setDescriptions($aRequestContent['App_offre']['descriptions']);
                $oOffre->addPhoto($oPhoto);
                $oOffre->setEtablissement($oEtablissement);
                $oEm = $this->getDoctrine()->getManager();
                $oEm->persist($oOffre);
                $oEm->flush();
            }
            return $this->redirectToRoute('admin_offre_index');
        }

        return $this->render('admin/offre/new.html.twig', ['etablissement' => $oEtablissement]);
    }

    /**
     * Finds and displays a offre entity.
     *
     * @Route("/{id}/show", name="admin_offre_show",methods={"GET"})
     */
    public function showAction(Offre $oOffre){
        return $this->render('admin/offre/show.html.twig', array(
            'offre' => $oOffre
        ));
    }

    /**
     * Displays a form to edit an existing offre entity.
     *
     * @Route("/{id}/edit", name="admin_offre_edit",methods={"GET","POST"})
     */
    public function editAction(Request $oRequest, Offre $oOffre){
        $oEditForm = $this->createForm('App\Form\OffreType', $oOffre);
        $oEditForm->handleRequest($oRequest);

        if ($oEditForm->isSubmitted() && $oEditForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_offre_index');
        }

        return $this->render('admin/offre/edit.html.twig', array(
            'offre' => $oOffre,
            'edit_form' => $oEditForm->createView()
        ));
    }

    /**
     * Deletes a offre entity.
     *
     * @Route("/{id}", name="admin_offre_delete",methods={"DELETE"})
     */
    public function deleteAction(Request $oRequest, Offre $oOffre){
        if ($oRequest->getMethod() == 'DELETE'){
            $oEm = $this->getDoctrine()->getManager();
            $oEm->remove($oOffre);
            $oEm->flush();
        }

        return $this->redirectToRoute('admin_offre_index');
    }

    /**
     * Creates a form to delete a offre entity.
     *
     * @param Offre $offre The offre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Offre $oOffre){
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_offre_delete', array('id' => $oOffre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Deletes a etablissement entity.
     *
     * @Route("/{id}/delete", name="offre_delete_link",methods={"GET"})
     */
    public function linkDeleteAction(Offre $oOffre){
        if (!empty($oOffre)) {
            $oEm = $this->getDoctrine()->getManager();
            $oEm->remove($oOffre);
            $oEm->flush();
        }
        return $this->redirectToRoute('admin_offre_index');
    }
}
