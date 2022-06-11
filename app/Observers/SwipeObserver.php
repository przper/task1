<?php

namespace App\Observers;

use App\Models\Pair;
use App\Models\Swipe;

class SwipeObserver
{
    /**
     * Handle the Swipe "created" event.
     *
     * @param  \App\Models\Swipe  $swipe
     * @return void
     */
    public function created(Swipe $swipe)
    {
        $isMatched = Swipe::query()
            ->whereOwnerId($swipe->target_id)
            ->whereTargetId($swipe->owner_id)
            ->exists();

        if ($isMatched) {
            Pair::create([
                'first_user_id' => $swipe->target_id,
                'second_user_id' => $swipe->owner_id,
            ]);
        }
    }

    /**
     * Handle the Swipe "updated" event.
     *
     * @param  \App\Models\Swipe  $swipe
     * @return void
     */
    public function updated(Swipe $swipe)
    {
        //
    }

    /**
     * Handle the Swipe "deleted" event.
     *
     * @param  \App\Models\Swipe  $swipe
     * @return void
     */
    public function deleted(Swipe $swipe)
    {
        $pair = Pair::query()
            ->where([
                ['first_user_id', $swipe->owner_id],
                ['second_user_id', $swipe->target_id]
            ])
            ->orWhere([
                ['first_user_id', $swipe->target_id],
                ['second_user_id', $swipe->owner_id]
            ]);

        $pair->delete();
    }

    /**
     * Handle the Swipe "restored" event.
     *
     * @param  \App\Models\Swipe  $swipe
     * @return void
     */
    public function restored(Swipe $swipe)
    {
        //
    }

    /**
     * Handle the Swipe "force deleted" event.
     *
     * @param  \App\Models\Swipe  $swipe
     * @return void
     */
    public function forceDeleted(Swipe $swipe)
    {
        //
    }
}
