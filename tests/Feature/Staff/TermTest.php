<?php

namespace Tests\Feature\Staff;

use App\Models\Term;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TermTest extends TestCase
{
    use RefreshDatabase;

    public function test_term_index_can_be_rendered()
    {
        $user = User::factory()->asStaff()->create();

        $response = $this->actingAs($user)->get(route('staff.terms.index'));

        $response->assertStatus(200);
    }

    public function test_can_create_term()
    {
        $user = User::factory()->asStaff()->create();

        $termData = [
            'tahun_ajaran' => '2025/2026',
            'start_date' => '2025-07-01',
            'end_date' => '2025-12-31',
            'is_active' => false,
            'kind' => 'ganjil',
        ];

        $response = $this->actingAs($user)->post(route('staff.terms.store'), $termData);

        $response->assertRedirect(route('staff.terms.index'));
        $this->assertDatabaseHas('terms', [
            'tahun_ajaran' => '2025/2026',
            'kind' => 'ganjil',
        ]);
    }

    public function test_can_update_term()
    {
        $user = User::factory()->asStaff()->create();
        $term = Term::factory()->create();

        $updateData = [
            'tahun_ajaran' => '2026/2027',
            'start_date' => '2026-01-01',
            'end_date' => '2026-06-30',
            'is_active' => true,
            'kind' => 'genap',
        ];

        $response = $this->actingAs($user)->put(route('staff.terms.update', $term->id), $updateData);

        $response->assertRedirect(route('staff.terms.index'));
        $this->assertDatabaseHas('terms', [
            'id' => $term->id,
            'tahun_ajaran' => '2026/2027',
            'kind' => 'genap',
            'is_active' => true,
        ]);
    }

    public function test_can_delete_term()
    {
        $user = User::factory()->asStaff()->create();
        $term = Term::factory()->create();

        $response = $this->actingAs($user)->delete(route('staff.terms.destroy', $term->id));

        $response->assertRedirect(route('staff.terms.index'));
        $this->assertDatabaseMissing('terms', ['id' => $term->id]);
    }
}
