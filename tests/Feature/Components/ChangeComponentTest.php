<?php

namespace Components;

use App\Models\Component;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ChangeComponentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_admin_can_change_a_component()
    {
        Storage::fake('public');

        $component = Component::create($this->getComponentRequest());

        $newComponent = $this->getComponentRequest(
            [
                'name' => 'Edited',
                'type' => 'Edited',
                'new_image' => $newImage = UploadedFile::fake()->image('edit.jpg'),
                'price' => 20.00,
            ]);

        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);

        $this->assertDatabaseHas(Component::class, [
            'id' => $component->id,
            'name' => 'Edited',
            'type' => 'Edited',
            'image' => $newImage->hashName('images/components'),
            'price' => 20.00,
        ]);

        $response->assertRedirect(route('components.show', $component));
    }

    /** @test */
    public function a_user_can_not_update_a_component()
    {
        $component = Component::create($this->getComponentRequest());
        $response = $this->actingAs(User::factory()->create())->put('/components/' . $component->id, $this->getComponentRequest());
        $response->assertForbidden();
    }

    /** @test */
    public function a_user_can_not_access_edit_page()
    {
        $component = Component::create($this->getComponentRequest());
        $response = $this->actingAs(User::factory()->create())->get('/components/' . $component->id . '/edit', $this->getComponentRequest());
        $response->assertForbidden();
    }

    /** @test */
    public function name_is_required()
    {
        $component = Component::create($this->getComponentRequest());

        $newComponent = $this->getComponentRequest(['name' => null]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);
        $response->assertInvalid('name');
    }

    /** @test */
    public function name_can_not_be_more_than_255_characters()
    {
        $component = Component::create($this->getComponentRequest());

        $newComponent = $this->getComponentRequest(['name' => str_repeat('A', 256)]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);
        $response->assertInvalid('name');

        $newComponent = $this->getComponentRequest(['name' => str_repeat('A', 255)]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);
        $response->assertValid();
    }

    /** @test */
    public function type_is_required()
    {
        $component = Component::create($this->getComponentRequest());

        $newComponent = $this->getComponentRequest(['type' => null]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);
        $response->assertInvalid('type');
    }

    /** @test */
    public function type_can_not_be_more_than_51_characters()
    {
        $component = Component::create($this->getComponentRequest());

        $newComponent = $this->getComponentRequest(['type' => str_repeat('A', 51)]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);
        $response->assertInvalid('type');

        $newComponent = $this->getComponentRequest(['type' => str_repeat('A', 50)]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);
        $response->assertValid();
    }

    /** @test */
    public function new_image_is_nullable()
    {
        $component = Component::create($this->getComponentRequest());
        $newComponent = $this->getComponentRequest();
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);

        $response->assertRedirect(route('components.show', $component));
    }

    /** @test */
    public function application_saves_new_image_on_disk()
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $component = Component::create($this->getComponentRequest());

        $newComponent = $this->getComponentRequest([
            'new_image' => $newImage = UploadedFile::fake()->image('new_image.jpg'),
        ]);

        $this->put('/components/' . $component->id, $newComponent);

        Storage::disk('public')->assertExists($newImage->hashName('images/components'));
    }

    /** @test */
    public function price_is_required()
    {
        $component = Component::create($this->getComponentRequest());
        $newComponent = $this->getComponentRequest(['price' => null]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);

        $response->assertInvalid('price');
    }

    /** @test */
    public function price_is_numeric()
    {
        $component = Component::create($this->getComponentRequest());
        $newComponent = $this->getComponentRequest(['price' => 'this_is_not_a_number']);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);

        $response->assertInvalid('price');
    }

    /** @test */
    public function price_is_higher_than_zero()
    {
        $component = Component::create($this->getComponentRequest());
        $newComponent = $this->getComponentRequest(['price' => -1]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);

        $response->assertInvalid('price');

        $component = Component::create($this->getComponentRequest());
        $newComponent = $this->getComponentRequest(['price' => 0]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);

        $response->assertValid();
    }

    /** @test */
    public function price_is_lower_than_100000()
    {
        $component = Component::create($this->getComponentRequest());
        $newComponent = $this->getComponentRequest(['price' => 100001]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);

        $response->assertInvalid('price');

        $component = Component::create($this->getComponentRequest());
        $newComponent = $this->getComponentRequest(['price' => 100000]);
        $response = $this->actingAs(User::factory()->create(['is_admin' => 1]))->put('/components/'.$component->id, $newComponent);

        $response->assertValid();
    }

    public function getComponentRequest($attributes = [])
    {
        return [
            'name' => 'Test_Component',
            'type' => 'Test',
            'old_image' => UploadedFile::fake()->image('old.jpg')->hashName('images/components'),
            'new_image' => null,
            'price' => 10.00,
            ...$attributes,
        ];
    }
}