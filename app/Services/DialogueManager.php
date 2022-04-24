<?php namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\Dialogue;

use App\Models\Character\Character;
use App\Models\User\User;

class DialogueManager extends Service
{
    /*-------------------------------------------------------
    |
    |   Parent Dialogue Functions
    |_______________________________________________________*/

    public function createDialogue($data)
    {
        DB::beginTransaction();
        
        try {
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'None') {
                $data['speaker_type'] = null;
                $data['speaker_id'] = null;
            } 
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'Response') {
                $data['speaker_id'] = null;
            } 
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'Narration') {
                $data['speaker_id'] = null;
                $data['speaker_name'] = '';
            }
            if(!isset($data['dialogue_name'])) {
                $data['dialogue_name'] = null;
            }
            if((isset($data['image_id']) && $data['image_id'] == 'None') || $data['speaker_type'] != 'Character') {
                $data['image_id'] = null;
            }
            if(!isset($data['img_url']) || $data['speaker_type'] != 'Narration') {
                $data['img_url'] = null;
            }
            
            $dialogue = Dialogue::create([
                'dialogue_name' => $data['dialogue_name'],
                'dialogue' => $data['dialogue'],
                'speaker_name' => $data['speaker_name'],
                'speaker_type' => $data['speaker_type'],
                'speaker_id' => $data['speaker_id'],
                'parent_id' => null,
                'image_id' => $data['image_id'],
                'img_url' => $data['img_url']
            ]);

            return $this->commitReturn($dialogue);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    public function updateDialogue($dialogue, $data)
    {
        DB::beginTransaction();

        try {

            if(isset($data['speaker_type']) && $data['speaker_type'] == 'None') {
                $data['speaker_type'] = null;
                $data['speaker_id'] = null;
            }
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'Response') {
                $data['speaker_id'] = null;
            } 
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'Narration') {
                $data['speaker_id'] = null;
                $data['speaker_name'] = '';
            }
            if(!isset($data['dialogue_name'])) {
                $data['dialogue_name'] = null;
            }
            if((isset($data['image_id']) && $data['image_id'] == 'None') || $data['speaker_type'] != 'Character') {
                $data['image_id'] = null;
            }
            if(!isset($data['img_url']) || $data['speaker_type'] != 'Narration') {
                $data['img_url'] = null;
            }

            $dialogue->update([
                'dialogue_name' => $data['dialogue_name'],
                'dialogue' => $data['dialogue'],
                'speaker_name' => $data['speaker_name'],
                'speaker_type' => $data['speaker_type'],
                'speaker_id' => $data['speaker_id'],
                'parent_id' => null,
                'image_id' => $data['image_id'],
                'img_url' => $data['img_url'],
            ]);

            return $this->commitReturn($dialogue);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /*-------------------------------------------------------
    |
    |   Child Dialogue Functions
    |_______________________________________________________*/

    public function createChildDialogue($id, $data)
    {
        DB::beginTransaction();
        
        try {
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'None') {
                $data['speaker_type'] = null;
                $data['speaker_id'] = null;
            } 
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'Response') {
                $data['speaker_id'] = null;
            } 
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'Narration') {
                $data['speaker_id'] = null;
            }
            if(!isset($data['dialogue_name'])) {
                $data['dialogue_name'] = null;
            }
            if((isset($data['image_id']) && $data['image_id'] == 'None') || $data['speaker_type'] != 'Character') {
                $data['image_id'] = null;
            }
            if(!isset($data['img_url']) || $data['speaker_type'] != 'Narration') {
                $data['img_url'] = null;
            }

            $dialogue = Dialogue::create([
                'dialogue_name' => $data['dialogue_name'],
                'dialogue' => $data['dialogue'],
                'speaker_name' => $data['speaker_name'],
                'speaker_type' => $data['speaker_type'],
                'speaker_id' => $data['speaker_id'],
                'parent_id' => $id,
                'image_id' => $data['image_id'],
                'img_url' => $data['img_url'],
            ]);

            return $this->commitReturn($dialogue);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    public function editChildDialogue($dialogue, $data)
    {
        DB::beginTransaction();
        
        try {
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'None') {
                $data['speaker_type'] = null;
                $data['speaker_id'] = null;
            } 
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'Response') {
                $data['speaker_id'] = null;
            } 
            if(isset($data['speaker_type']) && $data['speaker_type'] == 'Narration') {
                $data['speaker_id'] = null;
            }
            if(!isset($data['dialogue_name'])) {
                $data['dialogue_name'] = null;
            }
            if((isset($data['image_id']) && $data['image_id'] == 'None') || $data['speaker_type'] != 'Character') {
                $data['image_id'] = null;
            }
            if(!isset($data['img_url']) || $data['speaker_type'] != 'Narration') {
                $data['img_url'] = null;
            }

            $dialogue->update([
                'dialogue_name' => $data['dialogue_name'],
                'dialogue' => $data['dialogue'],
                'speaker_name' => $data['speaker_name'],
                'speaker_type' => $data['speaker_type'],
                'speaker_id' => $data['speaker_id'],
                'image_id' => $data['image_id'],
                'img_url' => $data['img_url'],
            ]);

            return $this->commitReturn($dialogue);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /*-------------------------------------------------------
    |
    |   Shared Dialogue Functions
    |_______________________________________________________*/

    public function deleteDialogue($dialogue)
    {
        DB::beginTransaction();

        try {
            // recursively delete all child dialogues
            foreach($dialogue->children as $child) {
                if($child->children) {
                    $this->deleteDialogue($child);
                }
                else {
                    $child->delete();
                }
            }
            $dialogue->delete();
            return $this->commitReturn($dialogue);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}