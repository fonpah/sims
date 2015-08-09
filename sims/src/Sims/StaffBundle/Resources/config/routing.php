<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('staff_homepage', new Route('/hello/{name}', array(
    '_controller' => 'StaffBundle:Default:index',
)));

return $collection;
