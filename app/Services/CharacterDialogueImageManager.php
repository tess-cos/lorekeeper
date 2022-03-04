<?php namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\Dialogue;

use App\Models\Character\Character;
use App\Models\Character\CharacterDialogueImage;
use App\Models\User\User;

class CharacterDialogueImageManager extends Service
{
    /*-------------------------------------------------------
    |
    |   Parent Dialogue Functions
    |_______________________________________________________*/

    /**
     * Create a new character dialogue image
     */
    public function createCharacterImage($data)
    {
        DB::beginTransaction();

        try {
            if(!$data['character_id']) throw new \Exception('No character selected.');
            if(!$data['emotion']) throw new \Exception('No emotion / identifier added.');
            if(!$data['image']) throw new \Exception('No image added.');

            if(CharacterDialogueImage::where('character_id', $data['character_id'])->where('emotion', $data['emotion'])->exists())
                throw new \Exception('An image for this character with this emotion already exists.');

            $image = CharacterDialogueImage::create($data);

            $this->handleImage($data['image'], $image->imagePath, $image->imageFileName);

            return $this->commitReturn($image);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Edit's a character's dialogue image
     */
    public function editCharacterImage($image, $data)
    {
        DB::beginTransaction();

        try {
            if(!$image) throw new \Exception('Character Dialogue Image not found.');
            if(!$data['character_id']) throw new \Exception('No character selected.');
            if(!$data['emotion']) throw new \Exception('No emotion / identifier added.');

            if(CharacterDialogueImage::where('id', '!=', $image->id)->where('character_id', $data['character_id'])->where('emotion', $data['emotion'])->exists())
                throw new \Exception('An image for this character with this emotion already exists.');

            $image->update($data);

            if(isset($data['image'])) $this->handleImage($data['image'], $image->imagePath, $image->imageFileName);

            return $this->commitReturn($image);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Delete a character's dialogue image
     */
    public function deleteCharacterImage($id)
    {
        DB::beginTransaction();

        try {
            $image = CharacterDialogueImage::find($id);
            if(!$image) throw new \Exception('Character Dialogue Image not found.');
            if(Dialogue::where('image_id', $id)->count()) throw new \Exception('This image is in use by a dialogue.');
            
            $this->deleteImage($image->imagePath, $image->imageFileName);

            $image->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}