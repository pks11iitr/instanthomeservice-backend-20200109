<?php
namespace App\Models\Traits;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;

trait DocumentUploadTrait {

    public function saveDocument($file, $urlprefix, $data=[]){
        $name = $file->getClientOriginalName();
        $contents = file_get_contents($file);
        $path = $urlprefix.'/' . $this->id . '/' . rand(111, 999) . '_' . str_replace(' ','_', $name);
        \Storage::put($path, $contents, 'public');

        $document=new Document(['doc_path'=>$path, 'uploaded_by'=>auth()->user()->id]);
        $this->gallery()->save($document);
    }

    public function gallery(){
        return $this->morphMany('App\Models\Document', 'entity');
    }

}
