<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ScheduleController
 */
class ScheduleControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $schedules = Schedule::factory()->count(3)->create();

        $response = $this->get(route('schedule.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ScheduleController::class,
            'store',
            \App\Http\Requests\ScheduleControllerStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $schedulable_id = $this->faker->word;
        $schedulable_type = $this->faker->word;
        $weekday = $this->faker->word;
        $start_hour = $this->faker->numberBetween(-10000, 10000);
        $start_minute = $this->faker->numberBetween(-10000, 10000);
        $end_hour = $this->faker->numberBetween(-10000, 10000);
        $end_minute = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('schedule.store'), [
            'schedulable_id' => $schedulable_id,
            'schedulable_type' => $schedulable_type,
            'weekday' => $weekday,
            'start_hour' => $start_hour,
            'start_minute' => $start_minute,
            'end_hour' => $end_hour,
            'end_minute' => $end_minute,
        ]);

        $schedules = Schedule::query()
            ->where('schedulable_id', $schedulable_id)
            ->where('schedulable_type', $schedulable_type)
            ->where('weekday', $weekday)
            ->where('start_hour', $start_hour)
            ->where('start_minute', $start_minute)
            ->where('end_hour', $end_hour)
            ->where('end_minute', $end_minute)
            ->get();
        $this->assertCount(1, $schedules);
        $schedule = $schedules->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $schedule = Schedule::factory()->create();

        $response = $this->get(route('schedule.show', $schedule));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ScheduleController::class,
            'update',
            \App\Http\Requests\ScheduleControllerUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $schedule = Schedule::factory()->create();
        $schedulable_id = $this->faker->word;
        $schedulable_type = $this->faker->word;
        $weekday = $this->faker->word;
        $start_hour = $this->faker->numberBetween(-10000, 10000);
        $start_minute = $this->faker->numberBetween(-10000, 10000);
        $end_hour = $this->faker->numberBetween(-10000, 10000);
        $end_minute = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('schedule.update', $schedule), [
            'schedulable_id' => $schedulable_id,
            'schedulable_type' => $schedulable_type,
            'weekday' => $weekday,
            'start_hour' => $start_hour,
            'start_minute' => $start_minute,
            'end_hour' => $end_hour,
            'end_minute' => $end_minute,
        ]);

        $schedule->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($schedulable_id, $schedule->schedulable_id);
        $this->assertEquals($schedulable_type, $schedule->schedulable_type);
        $this->assertEquals($weekday, $schedule->weekday);
        $this->assertEquals($start_hour, $schedule->start_hour);
        $this->assertEquals($start_minute, $schedule->start_minute);
        $this->assertEquals($end_hour, $schedule->end_hour);
        $this->assertEquals($end_minute, $schedule->end_minute);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $schedule = Schedule::factory()->create();

        $response = $this->delete(route('schedule.destroy', $schedule));

        $response->assertNoContent();

        $this->assertModelMissing($schedule);
    }
}
