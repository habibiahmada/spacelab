<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Major;

class MajorController extends Controller
{
    public function index(Request $request)
    {
        $query = Major::with(['headOfMajor', 'programCoordinator'])
            ->orderBy('name');

        if ($search = $request->input('search')) {
            $query->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('code', 'ILIKE', "%{$search}%")
                  ->orWhere('description', 'ILIKE', "%{$search}%")
                  ->orWhereHas('headOfMajor', fn($q) => $q->where('name', 'ILIKE', "%{$search}%"))
                  ->orWhereHas('programCoordinator', fn($q) => $q->where('name', 'ILIKE', "%{$search}%"));
        }

        $majors = $query->paginate(10)->withQueryString();

        return view('admin.pages.majors', [
            'majors' => $majors,
            'title' => 'Lihat Jurusan',
            'description' => 'Semua Jurusan',
        ]);
    }
}
