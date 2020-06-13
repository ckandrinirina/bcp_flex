<?php

namespace App\Manager\Restaurant;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Picture;
use App\Entity\Restaurant;

class RestaurantManager
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function saveRestaurantFromAjax($request, $restaurant)
    {
        $data_restaurant = $request->request->all()['restaurant'];
        $data_picture = $request->files->all()['restaurant']['pictures'];
        $restaurant->setNom($data_restaurant['nom']);
        $restaurant->setAdress($data_restaurant['adress']);
        $restaurant->setLatitude($data_restaurant['latitude']);
        $restaurant->setLongitude($data_restaurant['longitude']);
        $restaurant->setTelFixe($data_restaurant['tel_fixe']);
        $restaurant->setTelAutre($data_restaurant['tel_autre']);
        $restaurant->setEmail($data_restaurant['email']);
        $restaurant->setSite($data_restaurant['site']);
        $restaurant->setSpeciality($data_restaurant['speciality']);
        $restaurant->setPrice($data_restaurant['price']);
        $restaurant->setDescription($data_restaurant['description']);
        for ($i = 0; $i < count($data_picture); $i++) {
            $file = $data_picture[$i];
            $picture = new Picture();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $uploads_directory = Restaurant::uploads_directory_restaurant;
            $file->move(
                $uploads_directory,
                $filename
            );
            $picture->setUrl($uploads_directory . '/' . $filename);
            $picture->setName($filename);
            $this->entityManager->persist($picture);
            $restaurant->addPicture($picture);
        }
        $this->entityManager->persist($restaurant);
        $this->entityManager->flush();
    }
}
