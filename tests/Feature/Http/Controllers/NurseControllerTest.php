<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Nurse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\NurseController
 */
class NurseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $nurses = Nurse::factory()->count(3)->create();

        $response = $this->get(route('nurse.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NurseController::class,
            'store',
            \App\Http\Requests\NurseControllerStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $nurse_id = $this->faker->word;
        $nurse_name = $this->faker->word;

        $response = $this->post(route('nurse.store'), [
            'nurse_id' => $nurse_id,
            'nurse_name' => $nurse_name,
        ]);

        $nurses = Nurse::query()
            ->where('nurse_id', $nurse_id)
            ->where('nurse_name', $nurse_name)
            ->get();
        $this->assertCount(1, $nurses);
        $nurse = $nurses->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $nurse = Nurse::factory()->create();

        $response = $this->get(route('nurse.show', $nurse));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NurseController::class,
            'update',
            \App\Http\Requests\NurseControllerUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $nurse = Nurse::factory()->create();
        $nurse_id = $this->faker->word;
        $nurse_name = $this->faker->word;

        $response = $this->put(route('nurse.update', $nurse), [
            'nurse_id' => $nurse_id,
            'nurse_name' => $nurse_name,
        ]);

        $nurse->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($nurse_id, $nurse->nurse_id);
        $this->assertEquals($nurse_name, $nurse->nurse_name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $nurse = Nurse::factory()->create();

        $response = $this->delete(route('nurse.destroy', $nurse));

        $response->assertNoContent();

        $this->assertModelMissing($nurse);
    }
}
