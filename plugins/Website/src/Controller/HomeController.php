<?php


namespace Website\Controller;


use Cake\ORM\TableRegistry;

class HomeController extends AppController
{

    public function index()
    {

        $sliders = TableRegistry::getTableLocator()->get('Admin.Sliders')
            ->getData();


        $this->set(compact('sliders'));
    }

}