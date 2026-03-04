<?php

/**
 * Home Controller
 */
class HomeController extends Controller
{
    public function index()
    {
        $foodModel = $this->model('FoodModel');
        $reviewModel = $this->model('ReviewModel');

        $this->view('home/index', [
            'topFoods' => $foodModel->getTopSelling(8),
            'reviews' => $reviewModel->getApproved(),
            'avgRating' => $reviewModel->getAverageRating(),
        ]);
    }
}
