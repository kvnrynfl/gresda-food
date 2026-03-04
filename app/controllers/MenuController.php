<?php

/**
 * Menu Controller
 */
class MenuController extends Controller
{
    public function index()
    {
        $foodModel = $this->model('FoodModel');
        $categoryModel = $this->model('CategoryModel');

        $keyword = $_GET['q'] ?? $_GET['keyword'] ?? '';
        $category = $_GET['category'] ?? 'all';
        $sort = $_GET['sort'] ?? 'newest';

        $foods = $foodModel->getFiltered($keyword, $category, $sort);
        $categories = $categoryModel->getActive();

        $this->view('home/menu', [
            'title' => 'Menu Kami',
            'foods' => $foods,
            'categories' => $categories,
            'active_category' => $category,
            'active_sort' => $sort,
            'search_keyword' => $keyword,
        ]);
    }

    /**
     * AJAX endpoint for food data
     */
    public function getFood()
    {
        $foodModel = $this->model('FoodModel');

        $keyword = $_GET['q'] ?? $_GET['keyword'] ?? '';
        $category = $_GET['category'] ?? 'all';
        $sort = $_GET['sort'] ?? 'newest';

        $foods = $foodModel->getFiltered($keyword, $category, $sort);

        $this->json([
            'status' => 'success',
            'foods' => $foods,
            'count' => count($foods),
            'baseurl' => BASEURL,
        ]);
    }

    /**
     * Show single food detail
     */
    public function detail($id = '')
    {
        if (empty($id)) {
            $this->show404();
        }

        $foodModel = $this->model('FoodModel');
        $food = $foodModel->getById($id);

        if (!$food || !$food['is_active']) {
            $this->show404();
        }

        // Get related foods from same category
        $related = $foodModel->getByCategory($food['category_slug']);

        $this->view('menu/detail', [
            'food' => $food,
            'related' => $related,
        ]);
    }
}
