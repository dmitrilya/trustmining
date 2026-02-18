<?php

namespace App\Services\Insight;

use App\Models\Insight\Channel;
use App\Models\Insight\Series;

class SeriesService
{
    /**
     * Update the specified resource in storage.
     * 
     * @param Channel  $channel
     * @param string  $name
     * @return Series
     */
    public function store(Channel $channel, string $name): Series
    {
        return $channel->series()->create(['name' => $name]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Series  $series
     * @param string  $name
     * @return Series
     */
    public function update(Series $series, string $name): Series
    {
        $series->name = $name;
        $series->save;

        return $series;
    }

    /**
     * Destroy the specified resource in storage.
     * 
     * @param Channel  $channel
     * @return void
     */
    public function destroy(Channel $channel): void
    {
        $channel->delete();
    }
}
