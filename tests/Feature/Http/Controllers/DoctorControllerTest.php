<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DoctorController
 */
class DoctorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $doctors = Doctor::factory()->count(3)->create();

        $response = $this->get(route('doctor.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DoctorController::class,
            'store',
            \App\Http\Requests\DoctorControllerStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $doctor_id = $this->faker->word;
        $doctor_name = $this->faker->word;
        $poli = $this->faker->word;

        $response = $this->post(route('doctor.store'), [
            'doctor_id' => $doctor_id,
            'doctor_name' => $doctor_name,
            'poli' => $poli,
        ]);

        $doctors = Doctor::query()
            ->where('doctor_id', $doctor_id)
            ->where('doctor_name', $doctor_name)
            ->where('poli', $poli)
            ->get();
        $this->assertCount(1, $doctors);
        $doctor = $doctors->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $doctor = Doctor::factory()->create();

        $response = $this->get(route('doctor.show', $doctor));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DoctorController::class,
            'update',
            \App\Http\Requests\DoctorControllerUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $doctor = Doctor::factory()->create();
        $doctor_id = $this->faker->word;
        $doctor_name = $this->faker->word;
        $poli = $this->faker->word;

        $response = $this->put(route('doctor.update', $doctor), [
            'doctor_id' => $doctor_id,
            'doctor_name' => $doctor_name,
            'poli' => $poli,
        ]);

        $doctor->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($doctor_id, $doctor->doctor_id);
        $this->assertEquals($doctor_name, $doctor->doctor_name);
        $this->assertEquals($poli, $doctor->poli);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $doctor = Doctor::factory()->create();

        $response = $this->delete(route('doctor.destroy', $doctor));

        $response->assertNoContent();

        $this->assertModelMissing($doctor);
    }
}
