<?php

namespace App\Manager\Recette;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Picture;
use App\Entity\Recette;

class RecetteManager
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function saveRecetteFromAjax($request, $recette)
    {
        $data_recette = $request->request->all()['recette'];
        $data_picture = $request->files->all()['recette']['pictures'];

        $recette->setNom($data_recette['nom']);
        $recette->setEtapes($data_recette['etapes']);
        for ($i = 0; $i < count($data_picture); $i++) {
            $file = $data_picture[$i];
            $picture = new Picture();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $uploads_directory = Recette::uploads_directory_recette;
            $file->move(
                $uploads_directory,
                $filename
            );
            $picture->setUrl($uploads_directory . '/' . $filename);
            $picture->setName($filename);
            $this->entityManager->persist($picture);
            $recette->addPicture($picture);
        }
        $this->entityManager->persist($recette);
        $this->entityManager->flush();
    }
}
