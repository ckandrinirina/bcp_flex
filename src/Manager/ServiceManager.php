<?php

namespace App\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Etablissement;
use App\Entity\Photo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ServiceManager implements ServiceManagerInterface
{

    protected $oContainer;
    protected $em;
    private $oEtablissementRepository;


    public function __construct(ContainerInterface $oContainer) {
        $this->oContainer = $oContainer;
        $this->oEm = $oContainer->get('doctrine.orm.entity_manager');
        $this->oEtablissementRepository = $this->oEm->getRepository('App:Etablissement');
    }

    public function searchEtablissement($aParam = []) {
        return $this->oEtablissementRepository->searchEtablissement($aParam);
    }

    public function getEtablissement($sType) {
        return $this->oEtablissementRepository->listEtablissement($sType);
    }

    public function sendMail($sendTo, $name, $email, $text, $subject) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "From: " . $email . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $message = '<table style="width:100%">
            <tr><td>sujet: ' . $subject . '</td></tr>
            <tr><td>nom: ' . $name . '</td></tr>
            <tr><td>Email: ' . $email . '</td></tr>
            <tr><td>phone: ' . $subject . '</td></tr>
            <tr><td>message: ' . $text . '</td></tr>
        </table>';
        return true;
        if (@mail($sendTo, $email, $message, $headers)) {
            return true;
        } else {
            return true;
        }
    }
    
    public function generateStarEtablissementsOfArray($aEtablissement) {
        $aResult = [];
        foreach ($aEtablissement as $oEtablissement) {
            $note = $oEtablissement->getNote();
            for($i = 0; $i < 5; $i++){
            $oEtablissement->stars [$i]= false;
                if ($i < $note) {
                    $oEtablissement->stars [$i]= true;
                }
            }
            $aResult []= $oEtablissement;
        }
        return $aResult;
    }
    
    public function createEtablissement($oContainer, $aRequestContent, $oFile, $bSave = true) {
        $oEtablissement = new Etablissement();
        if (!empty($oFile)) {
            $sUploadDir = $oContainer->getParameter('path_uploads');
            $oPhoto = new Photo($oFile, $sUploadDir);
            $oPhoto->setEtablissement($oEtablissement);
            $oPhoto->setType('etablissement');
            $oDataManager = $oContainer->get('liip_imagine.data.manager');
            $oFilterManager = $oContainer->get('liip_imagine.filter.manager');
            $result = $oPhoto->createThumb($oDataManager, $oFilterManager);
            $oEtablissement->addPhoto($oPhoto);
        }
        $oEtablissement->setNom($aRequestContent['App_etablissement']['nom']);
        $oEtablissement->setAdresse($aRequestContent['App_etablissement']['adresse']);
        $oEtablissement->setAutre($aRequestContent['App_etablissement']['autre']);
        $oEtablissement->setEmail($aRequestContent['App_etablissement']['email']);
        $oEtablissement->setFixe($aRequestContent['App_etablissement']['fixe']);
        $oEtablissement->setNom($aRequestContent['App_etablissement']['nom']);
        $oEtablissement->setNote($aRequestContent['App_etablissement']['note']);
        $oEtablissement->setPrix($aRequestContent['App_etablissement']['prix']);
        $oEtablissement->setSite($aRequestContent['App_etablissement']['site']);
        $oEtablissement->setSpecialite($aRequestContent['App_etablissement']['specialite']);
        $oEtablissement->setType($aRequestContent['App_etablissement']['type']);
        if ($bSave) {
            $oEtablissement = $this->crudObject($oEtablissement);
        }
        return $oEtablissement;
    }
    
    public function crudObject($object, $sType = 'create') {
        try {
            if ($sType == 'update') {
                $this->oEm->merge($object);
            } elseif ($sType == 'remove') {
                $this->oEm->remove($object);
            } else {
                $this->oEm->persist($object);
            }
            $this->oEm->flush();
            return $object;
        } catch (\Exception $ex) {
            return $ex;
        }
        return null;
    }
    
    public function getOneEtablissement($aParam) {
        return $this->oEtablissementRepository->findOneBy($aParam);
    }

}
