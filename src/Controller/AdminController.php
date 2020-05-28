<?php

namespace App\Controller;

use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class AdminController extends Controller
{
    public $menu = 'dashboard';
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $nbrUser = count($em->getRepository(User::class)->findAll());
        $pictures = $em->getRepository(Picture::class)->findBestPictures();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'menu' => $this->menu,
            'nbrUser' => $nbrUser,
            'pictures' => $pictures
        ]);
    }
}
