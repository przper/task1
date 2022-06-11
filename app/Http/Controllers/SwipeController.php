<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SwipeController extends Controller
{
    /**
     * List of allowed actions types
     */
    public static $actions = [
        'create',
        'delete'
    ];

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'owner_id' => ['required', 'exists:users,id'],
            'target_id' => ['required', 'different:owner_id', 'exists:users,id'],
            'action' => ['required', Rule::in(self::$actions)]
        ]);

        if ($data['action'] == 'create') {
            return $this->handleSwipeCreation($data);
        }

        if ($data['action'] == 'delete') {
            return $this->handleSwipeDeletion($data);
        }
    }

    protected function handleSwipeCreation($data)
    {
        $user = User::find($data['owner_id']);

        if ($user->swipes()->whereTargetId($data['target_id'])->doesntExist()) {
            $user->swipes()->create(['target_id' => $data['target_id']]);
        }

        return response('', 201);
    }

    protected function handleSwipeDeletion($data)
    {
        $user = User::find($data['owner_id']);

        $swipe = $user->swipes()->whereTargetId($data['target_id'])->first();

        if ($swipe) {
            $swipe->delete();
        }

        return response('', 204);
    }
}
