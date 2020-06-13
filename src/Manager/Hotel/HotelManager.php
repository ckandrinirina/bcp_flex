<?php

namespace App\Manager\Hotel;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Picture;
use App\Entity\Hotel;

class HotelManager
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function saveHotelFromAjax($request, $hotel)
    {
        $data_hotel = $request->request->all()['hotel'];
        $data_picture = $request->files->all()['hotel']['pictures'];

        $hotel->setNom($data_hotel['nom']);
        $hotel->setAdress($data_hotel['adress']);
        $hotel->setLatitude($data_hotel['latitude']);
        $hotel->setLongitude($data_hotel['longitude']);
        $hotel->setTelFixe($data_hotel['tel_fixe']);
        $hotel->setTelAutre($data_hotel['tel_autre']);
        $hotel->setEmail($data_hotel['email']);
        $hotel->setSite($data_hotel['site']);
        $hotel->setSpeciality($data_hotel['speciality']);
        if ($data_hotel['price'] != "")
            $hotel->setPrice($data_hotel['price']);
        $hotel->setDescription($data_hotel['description']);
        for ($i = 0; $i < count($data_picture); $i++) {
            $file = $data_picture[$i];
            $picture = new Picture();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $uploads_directory = Hotel::uploads_directory_hotel;
            $file->move(
                $uploads_directory,
                $filename
            );
            $picture->setUrl($uploads_directory . '/' . $filename);
            $picture->setName($filename);
             $this->entityManager->persist($picture);
            $hotel->addPicture($picture);
        }
         $this->entityManager->persist($hotel);
         $this->entityManager->flush();
    }
}
