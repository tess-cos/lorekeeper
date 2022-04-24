<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Config;
use Illuminate\Http\Request;

use App\Models\Dialogue;

use App\Models\Character\Character;
use App\Models\Character\CharacterDialogueImage;
use App\Models\User\User;

use App\Services\DialogueManager;
use App\Services\CharacterDialogueImageManager;
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

    /**
     * Checks the speaker type
     */
    public function checkType(Request $request)
    {
        $type = $request->input('type');
        if($type == 'User') {
            return view('admin.dialogue._type', [
                'types' => User::orderBy('name')->pluck('name', 'id'),
                'type' => 'User',
            ]);
        }
        elseif($type == 'Character')
        {
            return view('admin.dialogue._type', [
                'types' => ['None' => 'Select a Character'] + Character::orderBy('name')->get()->pluck('fullName', 'id')->toArray(),
                'type' => 'Character',
            ]);
        }
        else return '';
    }

    /**
     * Gets the images for the dialogue
     */
    public function getImages(Request $request)
    {
        $id = $request->input('id');
        $dialogue = Dialogue::find($request->input('dialogue'));
        $character = Character::find($id);
        if(!$character) return 'Error finding character';

        return view('admin.dialogue._images', [
            'images' => ['None' => 'Select an Image'] + $character->dialogueImages->pluck('emotion', 'id')->toArray(),
            'dialogue' => $dialogue,
        ]);
    }

    /**
     * Create a dialogue
     */
    public function getCreateDialogue()
    {
        return view('admin.dialogue.create_edit_dialogue', [
            'dialogue' => new Dialogue,
            'types' => ['None' => 'Pick a Type'],
            'images' => ['None' => 'Select a Character']
        ]);
    }

    /**
     * get edit dialogue
     */
    public function getEditDialogue(Request $request, $id)
    {
        $dialogue = Dialogue::find($id);
        if(!$dialogue) abort(404);
        $images = [];
        if($dialogue->speaker_type == 'User') $type = User::orderBy('name')->pluck('name', 'id');
        elseif($dialogue->speaker_type == 'Character') {
            $type = Character::orderBy('name')->get()->pluck('fullName', 'id');
            $images = $dialogue->speaker->dialogueImages->pluck('emotion', 'id');
        }
        else $type = ['None' => 'Pick a Type'];

        return view('admin.dialogue.create_edit_dialogue', [
            'dialogue' => $dialogue,
            'types' => $type,
            'images' => $images
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
            'dialogue', 'speaker_name', 'speaker_type', 'speaker_id', 'dialogue_name', 'image_id'
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
            'id' => $id,
            'images' => []
        ]);
    }

    public function postCreateChildDialogue(Request $request, DialogueManager $service, $id)
    {
        $data = $request->only([
            'dialogue', 'speaker_name', 'speaker_type', 'speaker_id', 'image_id', 'dialogue_name'
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
        $images = [];
        if($dialogue->speaker_type == 'User') $type = User::orderBy('name')->pluck('name', 'id');
        elseif($dialogue->speaker_type == 'Character') {
            $type = Character::orderBy('name')->get()->pluck('fullName', 'id');
            $images = ['None' => 'Select an Image'] + $dialogue->speaker->dialogueImages->pluck('emotion', 'id')->toArray();
        }
        else $type = ['None' => 'Pick a Type'];

        return view('admin.dialogue._edit_modal', [
            'dialogue' => $dialogue,
            'types' => $type,
            'images' => $images
        ]);
    }

    public function postEditChildDialogue(Request $request, DialogueManager $service, $id)
    {
        $data = $request->only([
            'dialogue', 'speaker_name', 'speaker_type', 'speaker_id', 'image_id', 'dialogue_name'
        ]);
        if($service->editChildDialogue(Dialogue::find($id), $data)) {
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

    /*-------------------------------------------------------
    |
    |   Character Dialogue Functions
    |_______________________________________________________*/

    /**
     * Shows the index
     */
    public function getCharacterImages()
    {
        // get all characters who have dialogue images
        $characters = Character::whereHas('dialogueImages')->get();
        return view('admin.dialogue.characters.character_images', [
            'characters' => $characters,
        ]);
    }

    /**
     * get create character image view
     */
    public function getCreateCharacterImage()
    {
        return view('admin.dialogue.characters.create_edit_image', [
            'image' => new CharacterDialogueImage,
            'characters' => Character::orderBy('name')->get()->pluck('fullName', 'id')
        ]);
    }
    
    /**
     * get create character image view
     */
    public function getEditCharacterImage($id)
    {
        $image = CharacterDialogueImage::find($id);
        if(!$image) abort(404);
        return view('admin.dialogue.characters.create_edit_image', [
            'image' => $image,
            'characters' => Character::orderBy('name')->get()->pluck('fullName', 'id')
        ]);
    }

    /**
     * creates or edits a character image
     */
    public function postCreateEditCharacterImage(Request $request, CharacterDialogueImageManager $service, $id = null)
    {
        $id ? $request->validate(CharacterDialogueImage::$updateRules) : $request->validate(CharacterDialogueImage::$createRules);
        $data = $request->only([
            'character_id', 'emotion', 'image'
        ]);
        if($id && $service->editCharacterImage(CharacterDialogueImage::find($id), $data)) {
            flash('Character image updated successfully.')->success();
        }
        else if (!$id && $image = $service->createCharacterImage($data)) {
            flash('Character image created successfully.')->success();
            return redirect()->to('admin/dialogue/character-images/edit/'.$image->id);
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * get delete modal
     */
    public function getDeleteCharacterImage($id)
    {
        $image = CharacterDialogueImage::find($id);
        if(!$image) abort(404);
        return view('admin.dialogue.characters._delete_image', [
            'image' => $image
        ]);
    }

    /**
     * delete character image
     */
    public function postDeleteCharacterImage(Request $request, CharacterDialogueImageManager $service, $id)
    {
        if($service->deleteCharacterImage($id)) {
            flash('Character image deleted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/dialogue/character-images');
    }
}