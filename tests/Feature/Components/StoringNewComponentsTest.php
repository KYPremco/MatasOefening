<?php

namespace Tests\Feature\Components;

use App\Models\Component;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class StoringNewComponentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_store_a_new_component(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->admin()->create())
            ->post('/components', [
                'name' => 'ABC',
                'type' => 'AB',
                'image' => $file = UploadedFile::fake()->image('test.jpg'),
                'price' => 10.00,
            ])
            ->assertRedirect(route('components.show', ['component' => 1]));

        $this->assertDatabaseHas(Component::class, [
            'name' => 'ABC',
            'type' => 'AB',
            'image' => $file->hashName('images/components'),
            'price' => 10.00,
        ]);
    }

    /** @test */
    public function the_application_will_store_the_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin);

        $response = $this->post('/components', [
            'name' => 'ABC',
            'type' => 'AB',
            'image' => $file = UploadedFile::fake()->image('test.jpg'),
            'price' => 10.00,
        ]);

        Storage::disk('public')->assertExists($file->hashName('images/components'));
    }

    /** @test */
    public function a_normal_user_can_not_store_components(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user);

        $response = $this->post('/components', [
            'name' => 'ABC',
            'type' => 'AB',
            'image' => UploadedFile::fake()->image('test.jpg'),
            'price' => 10.00,
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function a_user_has_to_be_logged_in_to_store_components(): void
    {
        Storage::fake('public');

        $response = $this->post('/components', [
            'name' => 'ABC',
            'type' => 'AB',
            'image' => UploadedFile::fake()->image('test.jpg'),
            'price' => 10.00,
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function the_name_is_required(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin);

        $response = $this->from(route('components.create'))
            ->post('/components', $this->validPayload(['name' => null]));

        $response->assertRedirect(route('components.create'));
        $response->assertInvalid('name');

        $this->assertDatabaseCount(Component::class, 0);
    }

    /** @test */
    public function the_name_can_not_be_more_than_255_characters(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin);

        $response = $this->from(route('components.create'))
            ->post('/components', $this->validPayload(['name' => Str::repeat('A', 256)]));

        $response->assertRedirect(route('components.create'));
        $response->assertInvalid('name');

        $this->assertDatabaseCount(Component::class, 0);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'ABC',
            'type' => 'AB',
            'image' => UploadedFile::fake()->image('test.jpg'),
            'price' => 10.00,
        ], $overrides);
    }
}
