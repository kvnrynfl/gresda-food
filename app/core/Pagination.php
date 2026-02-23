<?php

class Pagination {
    public static function getLimitOffset($page, $limit) {
        $page = (int)$page > 0 ? (int)$page : 1;
        $offset = ($page - 1) * $limit;
        return "LIMIT $limit OFFSET $offset";
    }

    public static function createLinks($totalRecords, $limit, $currentPage, $baseUrl) {
        $totalPages = ceil($totalRecords / $limit);
        if ($totalPages <= 1) return '';

        $html = '<div class="pagination flex gap-2 justify-center mt-6">';
        
        if ($currentPage > 1) {
            $prev = $currentPage - 1;
            $html .= "<a href='{$baseUrl}?page={$prev}' class='px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300'>Prev</a>";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $currentPage) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300';
            $html .= "<a href='{$baseUrl}?page={$i}' class='px-4 py-2 rounded {$activeClass}'>{$i}</a>";
        }

        if ($currentPage < $totalPages) {
            $next = $currentPage + 1;
            $html .= "<a href='{$baseUrl}?page={$next}' class='px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300'>Next</a>";
        }

        $html .= '</div>';
        return $html;
    }
}
