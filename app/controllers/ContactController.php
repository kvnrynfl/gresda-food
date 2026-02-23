<?php

class ContactController extends Controller {

    public function index() {
        $data['title'] = 'Contact Us | Gresda Food & Beverage';
        $this->view('home/contact', $data);
    }
}
