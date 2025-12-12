<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    // allowed sections and whether they have image
    private $sections = [
        'about-us'     => ['name' => 'About Us',    'has_image' => true],
        'at-a-glance'  => ['name' => 'At a Glance','has_image' => false],
        'mission'      => ['name' => 'Mission',    'has_image' => true],
        'vision'       => ['name' => 'Vision',     'has_image' => true],
        'inspiration'  => ['name' => 'Inspiration','has_image' => true],
        'founder'      => ['name' => 'Founder',    'has_image' => true],
        'advisor'      => ['name' => 'Advisor',    'has_image' => true],
        'team'         => ['name' => 'Team',       'has_image' => true],
    ];

    private function getSectionOrFail($section)
    {
        if (!array_key_exists($section, $this->sections)) {
            abort(404);
        }
        return $this->sections[$section];
    }

    public function index($section)
    {
        $config  = $this->getSectionOrFail($section);
        $items   = About::where('section', $section)->latest()->get();

        return view('admin.about.index', compact('items', 'section', 'config'));
    }

    public function create($section)
    {
        $config = $this->getSectionOrFail($section);
        $item   = new About(); // empty model for form

        return view('admin.about.form', [
            'item'    => $item,
            'section' => $section,
            'config'  => $config,
            'route'   => route('admin.about.store', $section),
            'method'  => 'POST',
        ]);
    }

    public function store(Request $request, $section)
    {
        $config = $this->getSectionOrFail($section);

        $rules = [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|boolean',
        ];

        if ($config['has_image']) {
            $rules['image'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        $data = $request->validate($rules);
        $data['section'] = $section;

        if ($config['has_image'] && $request->hasFile('image')) {
            $path = $request->file('image')->store('about', 'public');
            $data['image'] = $path; // only path in DB
        }

        About::create($data);

        return redirect()->route('admin.about.index', $section)
                         ->with('success', $config['name'].' created successfully.');
    }

    public function edit($section, About $about)
    {
        $config = $this->getSectionOrFail($section);

        if ($about->section !== $section) {
            abort(404);
        }

        return view('admin.about.form', [
            'item'    => $about,
            'section' => $section,
            'config'  => $config,
            'route'   => route('admin.about.update', [$section, $about->id]),
            'method'  => 'PUT',
        ]);
    }

    public function update(Request $request, $section, About $about)
    {
        $config = $this->getSectionOrFail($section);

        if ($about->section !== $section) {
            abort(404);
        }

        $rules = [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|boolean',
        ];

        if ($config['has_image']) {
            $rules['image'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        $data = $request->validate($rules);

        if ($config['has_image'] && $request->hasFile('image')) {
            // delete old image if exists
            if ($about->image && Storage::disk('public')->exists($about->image)) {
                Storage::disk('public')->delete($about->image);
            }
            $path = $request->file('image')->store('about', 'public');
            $data['image'] = $path;
        }

        $about->update($data);

        return redirect()->route('admin.about.index', $section)
                         ->with('success', $config['name'].' updated successfully.');
    }

    public function destroy($section, About $about)
    {
        $config = $this->getSectionOrFail($section);

        if ($about->section !== $section) {
            abort(404);
        }

        if ($about->image && Storage::disk('public')->exists($about->image)) {
            Storage::disk('public')->delete($about->image);
        }

        $about->delete();

        return redirect()->route('admin.about.index', $section)
                         ->with('success', $config['name'].' deleted successfully.');
    }
}
