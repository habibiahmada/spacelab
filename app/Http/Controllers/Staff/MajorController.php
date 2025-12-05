<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $majors = Major::withCount(['classes', 'roleAssignments'])
            ->orderBy('code')
            ->paginate(9);

        return view('staff.major.index', [
            'majors' => $majors,
            'title' => 'Jurusan',
            'description' => 'Halaman manajemen jurusan',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:majors,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url|max:255',
            'contact_email' => 'nullable|email|max:255',
            'slogan' => 'nullable|string|max:255',
        ], [
            'code.required' => 'Kode jurusan wajib diisi',
            'code.unique' => 'Kode jurusan sudah digunakan',
            'name.required' => 'Nama jurusan wajib diisi',
            'logo.image' => 'File harus berupa gambar',
            'logo.max' => 'Ukuran gambar maksimal 2MB',
            'website.url' => 'Format website tidak valid',
            'contact_email.email' => 'Format email tidak valid',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('majors/logos', 'public');
        }

        Major::create($validated);

        return redirect()->route('staff.majors.index')
            ->with('success', 'Jurusan berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Major $major)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:10', Rule::unique('majors', 'code')->ignore($major->id)],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url|max:255',
            'contact_email' => 'nullable|email|max:255',
            'slogan' => 'nullable|string|max:255',
        ], [
            'code.required' => 'Kode jurusan wajib diisi',
            'code.unique' => 'Kode jurusan sudah digunakan',
            'name.required' => 'Nama jurusan wajib diisi',
            'logo.image' => 'File harus berupa gambar',
            'logo.max' => 'Ukuran gambar maksimal 2MB',
            'website.url' => 'Format website tidak valid',
            'contact_email.email' => 'Format email tidak valid',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($major->logo && Storage::disk('public')->exists($major->logo)) {
                Storage::disk('public')->delete($major->logo);
            }

            $validated['logo'] = $request->file('logo')->store('majors/logos', 'public');
        }

        $major->update($validated);

        return redirect()->route('staff.majors.index')
            ->with('success', 'Jurusan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major)
    {
        // Check if major has classes
        if ($major->classes()->count() > 0) {
            return redirect()->route('staff.majors.index')
                ->with('error', 'Jurusan tidak dapat dihapus karena masih memiliki kelas');
        }

        // Delete logo if exists
        if ($major->logo && Storage::disk('public')->exists($major->logo)) {
            Storage::disk('public')->delete($major->logo);
        }

        $major->delete();

        return redirect()->route('staff.majors.index')
            ->with('success', 'Jurusan berhasil dihapus');
    }
}
