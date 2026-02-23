<?php

class HomeController extends Controller {
    public function index() {
        $data['title'] = 'Home';
        // Get top 10 most ordered menus
        $foodModel = $this->model('FoodModel');
        $data['topFoods'] = $foodModel->getTopSelling(10);
        $this->view('home/index', $data);
    }
}
