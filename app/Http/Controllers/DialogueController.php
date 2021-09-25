<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

use App\Models\User\User;
use App\Models\Dialogue;

class DialogueController extends Controller
{
    public function getText(Request $request)
    {
        $id = $request->input('id');
        if(!$id) abort(404);
        $dialogue = Dialogue::find($id);

        $responses = [];

        foreach($dialogue->children as $child) {
            $responses[] = [
                'id' => $child->id,
                'dialogue' => $child->dialogue,
            ];
        }

        // if $dialogue->dialogue contains {Username} then replace it with the current user's username
        $dialogue->dialogue = str_replace('{Username}', Auth::user()->name, $dialogue->dialogue);

        return response()->json([
            'image' => '<img src="'.$dialogue->image.'">',
            'name' => $dialogue->displayName ?? ' ',
            'text' => $dialogue->dialogue,
            'responses' => $responses
        ]);
    }
}