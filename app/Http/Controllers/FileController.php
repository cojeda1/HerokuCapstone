<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use DB;

class FileController extends BaseController
{
  public function saveFile()
  {

      // $images = Input::file();
      // $images = $image['file'][2];
      $data = Input::all();
      // // $test = $data['data'];
      // $destinationPath = storage_path() . '/uploads';
      //      if(!$images->move($destinationPath, $images->getClientOriginalName())) {
      //          return $this->errors(['message' => 'Error saving the file.', 'code' => 400]);
      //      }
      //
      // $destinationPath = '../../../storage/uploads/' . $images->getClientOriginalName();
      //
      // DB::update('UPDATE images
      //   SET image_path = :blob
      //   WHERE image_id = 1' , ['blob' => $destinationPath]);
      return $data;
  }

    public function deleteFile($name)
    {
      $substring = substr($name, strpos($name, "d") + 2);
      unlink(storage_path() . '/uploads' . $substring);
      return response()->json('success');
    }

    public function getFileList(){

        $files = Storage::files('/');
        return response()->json($files);

    }

    public function viewFile($transaction_id) {

      $images =  DB::select('SELECT image_path
        FROM transactions natural join transactions_info natural join transaction_images natural join images
        WHERE transactions.transaction_id = :tid', ['tid' => $transaction_id]);

       return $images;

      }

}
