<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;

class AboutPageController extends Controller
{
    public function index()
    {
        $sections = [
            'about-us', 'at-a-glance', 'mission', 'vision',
            'inspiration', 'founder', 'advisor', 'team'
        ];

        // Fetch all active About module contents
        $data = About::whereIn('section', $sections)
                     ->where('status', 1)
                     ->orderByRaw("FIELD(section, 'about-us','at-a-glance','mission','vision','inspiration','founder','advisor','team')")
                     ->get()
                     ->groupBy('section');

        return view('frontend.about_page', compact('data'));
    }
}
