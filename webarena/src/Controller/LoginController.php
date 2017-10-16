<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP LoginController
 * @author julie
 */
class LoginController extends AppController {

    public function index($id) {
        $this->set('myname', "Julie");
        
    }

}
