<?php

namespace App\Http\Controllers\Staff\Major;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\CompanyRelation;
use Illuminate\Http\Request;

class CompanyRelationController extends Controller
{
    /**
     * Store a new company relation.
     */
    public function store(Request $request, Major $major)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'partnership_type' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,pending',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'document_link' => 'nullable|url',
        ]);

        $major->companyRelations()->create($validated);

        return redirect()->back()->with('success', 'Mitra perusahaan berhasil ditambahkan.');
    }

    /**
     * Update an existing company relation.
     */
    public function update(Request $request, Major $major, CompanyRelation $companyRelation)
    {
        // Ensure the company relation belongs to this major
        if ($companyRelation->major_id !== $major->id) {
            return redirect()->back()->with('error', 'Relasi perusahaan tidak valid untuk jurusan ini.');
        }

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'partnership_type' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,pending',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'document_link' => 'nullable|url',
        ]);

        try {
            $companyRelation->update($validated);
            return redirect()->back()->with('success', 'Mitra perusahaan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Delete a company relation.
     */
    public function destroy(Major $major, CompanyRelation $companyRelation)
    {
        // Ensure the company relation belongs to this major
        if ($companyRelation->major_id !== $major->id) {
            return redirect()->back()->with('error', 'Relasi perusahaan tidak valid untuk jurusan ini.');
        }

        try {
            $companyRelation->delete();
            return redirect()->back()->with('success', 'Mitra perusahaan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
