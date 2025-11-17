<?php

namespace Tests\Unit;

use App\Services\Chat\ArtCalculator;
use Carbon\Carbon;
use Tests\TestCase;

class ArtCalculatorTest extends TestCase
{
    private ArtCalculator $calc;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calc = new ArtCalculator;
        Carbon::setTestNow(Carbon::parse('2025-01-20 12:00:00'));
    }

    /** @test */
    public function it_counts_minutes_inside_working_hours()
    {
        $start = Carbon::parse('2025-01-20 12:00');
        $end   = Carbon::parse('2025-01-20 14:30');

        $minutes = $this->calcTest($start, $end);

        $this->assertEquals(150, $minutes);
    }

    /** @test */
    public function it_ignores_night_time_completely()
    {
        $start = Carbon::parse('2025-01-20 23:00');
        $end   = Carbon::parse('2025-01-21 08:00');

        $minutes = $this->calcTest($start, $end);

        $this->assertEquals(0, $minutes);
    }

    /** @test */
    public function it_counts_minutes_only_during_working_periods_across_days()
    {
        $start = Carbon::parse('2025-01-20 21:00'); // 1 час до 22:00
        $end   = Carbon::parse('2025-01-21 12:00'); // 1 час после 11:00

        // Итого: 60 (20:00–22:00) + 60 (11:00–12:00) = 120 минут
        $minutes = $this->calcTest($start, $end);

        $this->assertEquals(120, $minutes);
    }

    /** @test */
    public function it_handles_interval_within_night_completely_zero()
    {
        $start = Carbon::parse('2025-01-20 04:00');
        $end   = Carbon::parse('2025-01-20 07:00');

        $minutes = $this->calcTest($start, $end);

        $this->assertEquals(0, $minutes);
    }

    /** @test */
    public function it_trims_times_before_work_start_and_after_work_end()
    {
        $start = Carbon::parse('2025-01-20 10:00'); // до 11:00
        $end   = Carbon::parse('2025-01-20 23:00'); // после 22:00

        $minutes = $this->calcTest($start, $end);

        // рабочее окно: 11:00 — 22:00 = 11 часов = 660 минут
        $this->assertEquals(660, $minutes);
    }

    /** @test */
    public function it_returns_null_for_invalid_interval()
    {
        $start = Carbon::parse('2025-01-20 15:00');
        $end   = Carbon::parse('2025-01-20 14:00');

        $minutes = $this->calcTest($start, $end);

        $this->assertNull($minutes);
    }

    /** @test */
    public function zero_length_messages_result_in_zero_minutes()
    {
        $start = Carbon::parse('2025-01-20 13:00');
        $end   = Carbon::parse('2025-01-20 13:00');

        $minutes = $this->calcTest($start, $end);

        $this->assertNull($minutes);
    }

    private function calcTest($start, $end)
    {
        return $this->invokeMethod($this->calc, 'calculateEffectiveMinutes', [
            ['start' => $start, 'end' => $end]
        ]);
    }

    // Utility to call private methods via Reflection
    private function invokeMethod($object, string $method, array $params = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $methodRef = $reflection->getMethod($method);
        $methodRef->setAccessible(true);

        return $methodRef->invokeArgs($object, $params);
    }
}
