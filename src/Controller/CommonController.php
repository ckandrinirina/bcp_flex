<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommonController extends Controller
{
    protected $container;
    
    public function __construct() {
        global $kernel;
        $this->container = $kernel->getContainer();
    }
}
