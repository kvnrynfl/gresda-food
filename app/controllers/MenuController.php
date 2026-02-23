<?php

class MenuController extends Controller {

    public function index() {
        $categoryModel = $this->model('CategoryModel');
        $foodModel = $this->model('FoodModel');
        
        $data['title'] = 'Discover Our Menu';
        $data['categories'] = $categoryModel->getActive();
        $data['foods'] = $foodModel->getActive(); // Default all active foods
        $data['active_category'] = 'all';

        $this->view('home/menu', $data);
    }
    
    public function category($slug = '') {
        $categoryModel = $this->model('CategoryModel');
        $foodModel = $this->model('FoodModel');
        
        $category = $categoryModel->getByCategorySlug($slug);
        
        $data['title'] = 'Category: ' . ($category['name'] ?? 'All');
        $data['categories'] = $categoryModel->getActive();
        $data['active_category'] = $slug;

        if ($category) {
            $data['foods'] = $foodModel->getByCategory($slug);
        } else {
            // Fallback load all if category not found
            $data['foods'] = $foodModel->getActive();
            $data['active_category'] = 'all';
        }

        $this->view('home/menu', $data);
    }
}
