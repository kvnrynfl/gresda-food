<?php

/**
 * Pagination Helper
 * 
 * Generates pagination links and calculates offsets for paginated queries.
 */
class Pagination
{
    private $totalItems;
    private $itemsPerPage;
    private $currentPage;
    private $totalPages;

    public function __construct($totalItems, $itemsPerPage = 12, $currentPage = 1)
    {
        $this->totalItems = max(0, (int) $totalItems);
        $this->itemsPerPage = max(1, (int) $itemsPerPage);
        $this->currentPage = max(1, (int) $currentPage);
        $this->totalPages = (int) ceil($this->totalItems / $this->itemsPerPage);

        // Clamp current page
        if ($this->currentPage > $this->totalPages && $this->totalPages > 0) {
            $this->currentPage = $this->totalPages;
        }
    }

    public function getOffset()
    {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    public function getLimit()
    {
        return $this->itemsPerPage;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function hasPrevious()
    {
        return $this->currentPage > 1;
    }

    public function hasNext()
    {
        return $this->currentPage < $this->totalPages;
    }

    /**
     * Generate page links array
     * @param string $baseUrl Base URL for pagination links
     * @param int $adjacents Number of adjacent pages to show
     * @return array Pagination data
     */
    public function getLinks($baseUrl = '', $adjacents = 2)
    {
        $links = [];
        $start = max(1, $this->currentPage - $adjacents);
        $end = min($this->totalPages, $this->currentPage + $adjacents);

        // Previous
        if ($this->hasPrevious()) {
            $links[] = ['page' => $this->currentPage - 1, 'label' => '←', 'active' => false, 'url' => $baseUrl . ($this->currentPage - 1)];
        }

        // First page + ellipsis
        if ($start > 1) {
            $links[] = ['page' => 1, 'label' => '1', 'active' => false, 'url' => $baseUrl . '1'];
            if ($start > 2) {
                $links[] = ['page' => null, 'label' => '...', 'active' => false, 'url' => ''];
            }
        }

        // Page numbers
        for ($i = $start; $i <= $end; $i++) {
            $links[] = ['page' => $i, 'label' => (string)$i, 'active' => ($i === $this->currentPage), 'url' => $baseUrl . $i];
        }

        // Last page + ellipsis
        if ($end < $this->totalPages) {
            if ($end < $this->totalPages - 1) {
                $links[] = ['page' => null, 'label' => '...', 'active' => false, 'url' => ''];
            }
            $links[] = ['page' => $this->totalPages, 'label' => (string)$this->totalPages, 'active' => false, 'url' => $baseUrl . $this->totalPages];
        }

        // Next
        if ($this->hasNext()) {
            $links[] = ['page' => $this->currentPage + 1, 'label' => '→', 'active' => false, 'url' => $baseUrl . ($this->currentPage + 1)];
        }

        return $links;
    }
}
