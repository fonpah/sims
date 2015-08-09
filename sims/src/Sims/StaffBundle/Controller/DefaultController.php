<?php

namespace Sims\StaffBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StaffBundle:Default:index.html.twig', array('name' => $name));
    }
}
