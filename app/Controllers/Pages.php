<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
    public function home()
    {
        return view('home');
    }

    public function details()
    {
        return view('details');
    }

    public function agent()
    {
        return view('agent');
    }

    public function about()
    {
        return view('aboutus');
    }

    public function social(string $platform)
    {
        $platforms = [
            'patreon' => 'Patreon',
            'discord' => 'Discord',
            'x'       => 'X',
        ];

        if (! array_key_exists($platform, $platforms)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('social_placeholder', [
            'platformKey'  => $platform,
            'platformName' => $platforms[$platform],
        ]);
    }
}
