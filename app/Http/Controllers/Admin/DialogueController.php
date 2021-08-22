<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Config;
use Illuminate\Http\Request;

use App\Models\Dialogue;

use App\Models\Character\Character;
use App\Models\User\User;

use App\Services\DialogueManager;

use App\Http\Controllers\Controller;

class DialogueController extends Controller
{
    /*-------------------------------------------------------
    |
    |   Parent Dialogue Functions
    |_______________________________________________________*/

    /**
     * Get index
     */
    public function getIndex()
    {
        return view('admin.dialogue.dialogues', [
            'dialogues' => Dialogue::where('parent_id', null)->get()->paginate(10),
        ]);
    }

    public function checkType(Request $request)
    {
        $type = $request->input('type');
        if($type == 'User') {
            return view('admin.dialogue._type', [
                'types' => User::orderBy('name')->pluck('name', 'id')
            ]);
        }
        elseif($type == 'Character')
        {
            return view('admin.dialogue._type', [
                'types' => Character::orderBy('name')->get()->pluck('fullName', 'id')
            ]);
        }
        else return '';
    }

    /**
     * Create a dialogue
     */
    public function getCreateDialogue()
    {
        return view('admin.dialogue.create_edit_dialogue', [
            'dialogue' => new Dialogue,
            'types' => ['None' => 'Pick a Type']
        ]);
    }

    /**
     * get edit dialogue
     */
    public function getEditDialogue(Request $request, $id)
    {
        $dialogue = Dialogue::find($id);
        if(!$dialogue) abort(404);

        if($dialogue->speaker_type == 'User') $type = User::orderBy('name')->pluck('name', 'id');
        elseif($dialogue->speaker_type == 'Character') $type = Character::orderBy('name')->get()->pluck('fullName', 'id');
        else $type = ['None' => 'Pick a Type'];

        return view('admin.dialogue.create_edit_dialogue', [
            'dialogue' => $dialogue,
            'types' => $type
        ]);
    }

    /**
     * Creates or edits a dialogue.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\DialogueService  $service
     * @param  int|null                  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditDialogue(Request $request, DialogueManager $service, $id = null)
    {
        $data = $request->only([
            'dialogue', 'speaker_name', 'speaker_type', 'speaker_id'
        ]);
        if($id && $service->updateDialogue(Dialogue::find($id), $data)) {
            flash('Dialogue updated successfully.')->success();
        }
        else if (!$id && $dialogue = $service->createDialogue($data, Auth::user())) {
            flash('Dialogue created successfully.')->success();
            return redirect()->to('admin/dialogue/edit/'.$dialogue->id);
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /*-------------------------------------------------------
    |
    |   Children Dialogue Functions
    |_______________________________________________________*/

    public function getCreateChildDialogue($id)
    {
        return view('admin.dialogue._dialogue_child_modal', [
            'id' => $id
        ]);
    }

    public function postCreateChildDialogue(Request $request, DialogueManager $service, $id)
    {
        $data = $request->only([
            'dialogue', 'speaker_name', 'speaker_type', 'speaker_id'
        ]);

        if($service->createChildDialogue($id, $data)) {
            flash('Child dialogue created successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    public function getEditChildDialogue($id)
    {
        $dialogue = Dialogue::find($id);
        if(!$dialogue) abort(404);

        if($dialogue->speaker_type == 'User') $type = User::orderBy('name')->pluck('name', 'id');
        elseif($dialogue->speaker_type == 'Character') $type = Character::orderBy('name')->get()->pluck('fullName', 'id');
        else $type = ['None' => 'Pick a Type'];

        return view('admin.dialogue._edit_modal', [
            'dialogue' => $dialogue,
            'types' => $type
        ]);
    }

    public function postEditChildDialogue(Request $request, DialogueManager $service, $id)
    {
        $data = $request->only([
            'dialogue', 'speaker_name', 'speaker_type', 'speaker_id'
        ]);
        if($service->updateChildDialogue(Dialogue::find($id), $data)) {
            flash('Child dialogue updated successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /*-------------------------------------------------------
    |
    |   Shared Dialogue Functions
    |_______________________________________________________*/

    public function getDeleteDialogue($id)
    {
        $dialogue = Dialogue::find($id);
        if(!$dialogue) abort(404);
        return view('admin.dialogue._delete_modal', [
            'dialogue' => $dialogue
        ]);
    }

    public function postDeleteDialogue(Request $request, DialogueManager $service, $id)
    {
        $dialogue = Dialogue::find($id);
        if(!$dialogue) abort(404);

        if($dialogue->parent_id) $redirect = false;
        else $redirect = true;

        if($service->deleteDialogue($dialogue)) {
            flash('Dialogue deleted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        if($redirect) return redirect()->to('admin/dialogue');
        else return redirect()->back();
    }
}