<?php

declare(strict_types=1);

namespace App\Controller;

class HomeController extends AppController
{
    public function index()
    {
        $productsTable = $this->fetchTable('Products');
        $products      = $productsTable->find();

        $this->set('products', $products);
        $this->render('/home');
    }
}
