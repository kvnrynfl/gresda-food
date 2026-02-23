<?php

class AboutController extends Controller {

    public function index() {
        $data['title'] = 'About Us | Gresda Food & Beverage';
        $this->view('home/about', $data);
    }
}
