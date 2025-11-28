<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('code', 'ILIKE', "%{$search}%")
                  ->orWhere('building', 'ILIKE', "%{$search}%")
                  ->orWhere('type', 'ILIKE', "%{$search}%");
            });
        }

        $rooms = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return view('admin.pages.rooms', [
            'rooms' => $rooms,
            'title' => 'Lihat Ruangan',
            'description' => 'Semua Ruangan',
        ]);
    }
}
