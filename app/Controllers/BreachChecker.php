<?php

namespace App\Controllers;

class BreachChecker extends BaseController
{
    public function index()
    {
        // Menampilkan halaman utama (desain UI)
        return view('pwned_view');
    }

    public function checkEmail()
    {
        // Mengambil input email dari form
        $email = $this->request->getPost('email');
        
        // Di sini nantinya kamu akan melakukan request ke eksternal API 
        // (misalnya menggunakan cURL CI4 ke API pwned database)
        
        // Untuk tahap awal, kita bisa mengirim data dummy ke view
        $data = [
            'email' => $email,
            'status' => 'PWNED', // atau 'SAFE'
            'message' => 'Your email was found in our database!'
        ];

        return view('pwned_view', $data);
    }
}