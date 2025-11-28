<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassRoom;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassRoom::with(['major', 'homeroomTeacher'])
            ->orderBy('level');

        if ($search = $request->input('search')) {
            $query->where('rombel', 'ILIKE', "%{$search}%")
                  ->orWhere('level', 'ILIKE', "%{$search}%")
                  ->orWhereHas('major', fn($q) => $q->where('name', 'ILIKE', "%{$search}%"))
                  ->orWhereHas('homeroomTeacher', fn($q) => $q->where('name', 'ILIKE', "%{$search}%"));
        }

        $classes = $query->paginate(10)->withQueryString();

        return view('admin.pages.classes', [
            'classes' => $classes,
            'title' => 'Lihat Kelas',
            'description' => 'Semua Kelas',
        ]);
    }
}
