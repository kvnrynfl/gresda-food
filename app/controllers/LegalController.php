<?php

class LegalController extends Controller {

    public function terms() {
        $data['title'] = "Syarat & Ketentuan Layanan - Gresda Food";
        $this->view('legal/terms', $data);
    }

    public function privacy() {
        $data['title'] = "Kebijakan Privasi - Gresda Food";
        $this->view('legal/privacy', $data);
    }

}
