<?php
/**
 * Legal Controller — Static pages (Privacy Policy, Terms of Service)
 */
class LegalController extends Controller
{
    public function privacy()
    {
        $this->view('legal/privacy');
    }

    public function terms()
    {
        $this->view('legal/terms');
    }
}
