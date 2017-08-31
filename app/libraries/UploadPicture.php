<?php
namespace App\Libraries;

// upload picture library
class UploadPicture
{
    private $file;
    function __construct($files)
    {
        $files = array_values($files);
        if(!$files)
            $this->file = false;
        else
            $this->file = $files[0];
    }

    /**
     * description: save image
     * 
     */
    public function save()
    {
        // create destination image path
        $destination_image_path = getenv('UPLOAD_PATH').'/'.$this->getMd5Path().$this->getExtension();
        $destination_image_directory = dirname($destination_image_path);

        if(!is_dir($destination_image_directory))
        {
            mkdir($destination_image_directory, 0777, true);
        }

        return move_uploaded_file( $this->file['tmp_name'], $destination_image_path);
    }

    /**
     * description: get image extension
     * parameter: null
     * return: extension string
     */
    private function getExtension()
    {
        $info = getimagesize($this->file['tmp_name']);
        $extension = image_type_to_extension($info[2]);
        return $extension;
    }

    /**
     *  description: get md5 exploded path
     *  parameter: null
     *  return: extension string
     */
    private function getMd5Path()
    {
        $md5 = md5_file($this->file['tmp_name']);
        $md5_path = join('/', $this->explodeMd5($md5));
        return $md5_path;
    }

    /**
     * description: explode file md5
     * parameter: string $md5
     * return: array $arr
     */
    private function explodeMd5($md5)
    {
        if(!$md5)return false;
        $arr[1]=substr($md5, 0, 1);
        $arr[2]=substr($md5, 1, 2);
        $arr[3]=substr($md5, 3, 3);
        $arr[4]=substr($md5, 6, 4);
        $arr[5]=substr($md5, 10);
        return $arr; 
    }
}
