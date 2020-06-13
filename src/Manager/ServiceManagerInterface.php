<?php

namespace App\Manager;

interface ServiceManagerInterface
{
    public function searchEtablissement($aParam = []);
    public function getEtablissement($sType);
    public function sendMail($sendTo, $name, $email, $text, $subject);
    public function generateStarEtablissementsOfArray($aEtablissement);
    public function createEtablissement($oContainer, $aRequestContent, $oFile, $bSave = true);
    public function crudObject($object, $sType = 'create');
    public function getOneEtablissement($aParam);
}
