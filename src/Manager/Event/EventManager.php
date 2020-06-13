<?php

namespace App\Manager\Event;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Picture;
use App\Entity\Event;

class EventManager
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function saveEventFromAjax($request, $event)
    {
        $data_event = $request->request->all()['event'];
        $data_picture = $request->files->all()['event']['pictures'];

        $event->setNom($data_event['nom']);
        $event->setPresentation($data_event['presentation']);
        $event->setDate(\DateTime::createFromFormat('Y-m-d', $data_event['date']));
        $event->setPlace($data_event['place']);
        for ($i = 0; $i < count($data_picture); $i++) {
            $file = $data_picture[$i];
            $picture = new Picture();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $uploads_directory = Event::uploads_directory_event;
            $file->move(
                $uploads_directory,
                $filename
            );
            $picture->setUrl($uploads_directory . '/' . $filename);
            $picture->setName($filename);
            $this->entityManager->persist($picture);
            $event->addPicture($picture);
        }
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }
}
