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
     * @param string  $description
     * @return Series
     */
    public function store(Channel $channel, string $name, string $description): Series
    {
        return $channel->series()->create(['name' => $name, 'description' => $description]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Series  $series
     * @param string  $name
     * @param string  $description
     * @return Series
     */
    public function update(Series $series, string $name, string $description): Series
    {
        $series->name = $name;
        $series->description = $description;
        $series->save;

        return $series;
    }

    /**
     * Destroy the specified resource in storage.
     * 
     * @param Series  $series
     * @return void
     */
    public function destroy(Series $series): void
    {
        $series->delete();
    }
}
