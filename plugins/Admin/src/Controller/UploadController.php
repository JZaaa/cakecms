<?php
namespace Admin\Controller;

use Cake\Filesystem\Folder;
use Upload\File;
use Upload\Storage\FileSystem;

/**
 * 文件上传
 * Class UploadController
 * @package Admin\Controller
 */
class UploadController extends AppController
{

    private $path = 'files';

    private function setFolder()
    {
        $time = date('Ymd');
        $folder = new Folder();

        $path = $this->path . '/' . $time;

        if ($folder->create(WWW_ROOT . $path)) {
            return $path;
        } else {
            return false;
        }
    }

    /**
     * 图片上传
     * @return \App\Controller\AppController
     */
    public function image()
    {
        if ($path = $this->setFolder()) {
            $storage = new FileSystem($path);
            $file = new File('file', $storage);

            $new_filename = uniqid();
            $file->setName($new_filename);

            $file->addValidations(array(
                new \Upload\Validation\Mimetype(['image/png', 'image/gif', 'image/jpg', 'image/jpeg']),

                new \Upload\Validation\Size('5M')
            ));

            $errors = false;

            try {
                // Success!
                $file->upload();
            } catch (\Exception $e) {
                // Fail!
                $errors = current($file->getErrors());
            }

            if ($errors) {
                return $this->jsonResponse([
                    'code' => 300,
                    'message' => $errors
                ]);
            }

            $filePath = $path . '/' . $file->getName() . '.' . $file->getExtension();
            return $this->jsonResponse([
                'code' => 200,
                'message' => '上传成功',
                'data' => [
                    'filePath' => $filePath,
                    'fullPath' => ROOT . '/webroot/' . $filePath
                ]
            ]);

        }
    }


}