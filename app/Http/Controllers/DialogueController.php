<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Str;

use App\Models\User\User;
use App\Models\Dialogue;

class DialogueController extends Controller
{
    /**
     * Returns next dialogue in sequence 
     */
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
                'name' => $child->dialogue_name ?? Str::limit($child->dialogue, 25, $end='...')
            ];
        }

        // if $dialogue->dialogue contains {Username} then replace it with the current user's username
        if(Auth::check()) {
            $dialogue->dialogue = str_replace('{Username}', Auth::user()->username, $dialogue->dialogue);
        }
        else $dialogue->dialogue = str_replace('{Username}', 'You', $dialogue->dialogue);

        return response()->json([
            'image' => $dialogue->image ? '<img src="'.$dialogue->image.'" class="img-fluid">' : null,
            'name' => $dialogue->displayName ?? ' ',
            'text' => $dialogue->dialogue,
            'responses' => $responses,
            'img_url' => $dialogue->img_url ? '<img src="'.$dialogue->img_url.'" class="img-fluid mx-auto">' : null,
        ]);
    }
}