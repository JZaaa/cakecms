<?php
namespace Admin\Controller;

use Cake\Filesystem\Folder;
use Cake\Routing\Router;
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

    private $mimeType = [
        'image' => [
            'image/png', 'image/gif', 'image/jpg', 'image/jpeg', 'image/x-icon', 'image/gif', 'image/x-ms-bmp'
        ],
        'media' => [
            'application/x-shockwave-flash', 'audio/mpeg', 'video/vnd.rn-realvideo', 'video/mpeg', 'audio/mp4', 'video/mp4', 'audio/wav
'
        ],
        'file' => [
            'application/zip', 'application/x-7z-compressed', 'application/vnd.ms-excel', '	application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '	application/xml', 'application/x-tar', 'application/x-rar-compressed', 'application/pdf', 'application/msword', 'text/csv', 'application/x-bzip', 'application/octet-stream'
        ]
    ];

    private $type = ['image', 'media', 'file'];

    /**
     * 生成文件路径
     * @param null $type
     * @return bool|string
     */
    private function setFolder($type = null)
    {
        $time = date('Ymd');
        $folder = new Folder();

        if (in_array($type, $this->type)) {
            $path = $this->path . '/' . $type . '/' . $time;
        } else {
            $path = $this->path . '/default/' . $time;
        }

        if ($folder->create(WWW_ROOT . $path)) {
            return $path;
        } else {
            return false;
        }
    }

    /**
     * 保存公用方法
     * @param $path
     * @param File $file
     * @return array
     */
    private function save($path, File $file)
    {
        $errors = false;

        try {
            // Success!
            $file->upload();
        } catch (\Exception $e) {
            // Fail!
            $errors = current($file->getErrors());
        }

        if ($errors) {
            return [
                'code' => 300,
                'message' => $errors
            ];
        }

        $filePath = $path . '/' . $file->getName() . '.' . $file->getExtension();
        return [
            'code' => 200,
            'message' => '上传成功',
            'data' => [
                'filePath' => $filePath,
                'fullPath' => ROOT . '/webroot/' . $filePath
            ]
        ];
    }

    /**
     * 文件上传公共方法
     * @param $type null|string 文件类型
     * @param $fileName string upload字段
     * @return array
     */
    private function upload($type = null, $fileName = 'file')
    {
        // 文件类型，image,media,file
        $type = empty($type) ? $this->request->getQuery('dir') : $type;

        if ($path = $this->setFolder($type)) {
            $storage = new FileSystem($path);
            $file = new File($fileName, $storage);

            $new_filename = uniqid();
            $file->setName($new_filename);

            if (in_array($type, $this->type)) {
                $mimeType = $this->mimeType[$type];
            } else {
                $mimeType = [];
                foreach ($this->mimeType as $item) {
                    $mimeType = array_merge($mimeType, $item);
                }
            }

            $file->addValidations(array(
                new \Upload\Validation\Mimetype($mimeType),

                new \Upload\Validation\Size('5M')
            ));

            return $this->save($path, $file);
        }

        return [
            'code' => 300,
            'message' => '上传文件失败！请检查路径权限'
        ];
    }

    /**
     * 图片上传
     * @return \App\Controller\AppController
     */
    public function image()
    {
        return $this->jsonResponse($this->upload('image'));
    }

    /**
     * 媒体上传
     * @return \App\Controller\AppController
     */
    public function media()
    {
        return $this->jsonResponse($this->upload('media'));
    }

    /**
     * 其他文件上传
     * @return \App\Controller\AppController
     */
    public function file()
    {
        return $this->jsonResponse($this->upload('file'));
    }


    /**
     * kindeditor上传
     * @return UploadController
     */
    public function keUpload()
    {
        $res = $this->upload(null, 'imgFile');

        if ($res['code'] == 200) {
            return $this->apiResponse([
                'error' => 0,
                'url' => Router::url('/' . $res['data']['filePath'])
            ]);
        }

        return $this->apiResponse([
            'error' => 1,
            'message' => $res['message']
        ]);
    }

    /**
     * kindeditor 文件管理
     * @url http://www.thinkphp.cn/topic/27200.html
     * @return UploadController
     */
    public function fileManager()
    {
        $root_path = WWW_ROOT . 'files/';
        //根目录URL
        $root_url = Router::url('/files/');
        //图片扩展名
        $ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
        //目录名
        $dir_name = empty($_GET['dir']) ? '' : trim($_GET['dir']);
        //不在上传目录退出
        if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
            echo "Invalid Directory name.";
            exit;
        }
        if ($dir_name !== '') {
            $root_path .= $dir_name . "/";
            $root_url .= $dir_name . "/";
            if (!file_exists($root_path)) {
                mkdir($root_path);
            }
        }
        //根据path参数，设置各路径和URL
        if (empty($_GET['path'])) {
            $current_path = realpath($root_path) . '/';
            $current_url = $root_url;
            $current_dir_path = '';
            $moveup_dir_path = '';
        } else {
            $current_path = realpath($root_path) . '/' . $_GET['path'];
            $current_url = $root_url . $_GET['path'];
            $current_dir_path = $_GET['path'];
            $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
        }
        //不允许使用..移动到上一级目录
        if (preg_match('/\.\./', $current_path)) {
            echo 'Access is not allowed.';
            exit;
        }
        //最后一个字符不是/
        if (!preg_match('/\/$/', $current_path)) {
            echo 'Parameter is not valid.';
            exit;
        }
        //目录不存在或不是目录
        if (!file_exists($current_path) || !is_dir($current_path)) {
            echo 'Directory does not exist.';
            exit;
        }
        //遍历目录取得文件信息
        $file_list = array();
        if ($handle = opendir($current_path)) {
            $i = 0;
            while (false !== ($filename = readdir($handle))) {
                if ($filename{0} == '.')
                    continue;
                $file = $current_path . $filename;
                if (is_dir($file)) {
                    $file_list[$i]['is_dir'] = true; //是否文件夹
                    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
                    $file_list[$i]['filesize'] = 0; //文件大小
                    $file_list[$i]['is_photo'] = false; //是否图片
                    $file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
                } else {
                    $file_list[$i]['is_dir'] = false;
                    $file_list[$i]['has_file'] = false;
                    $file_list[$i]['filesize'] = filesize($file);
                    $file_list[$i]['dir_path'] = '';
                    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
                    $file_list[$i]['filetype'] = $file_ext;
                }
                $file_list[$i]['filename'] = $filename; //文件名，包含扩展名
                $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
                $i++;
            }
            closedir($handle);
        }

        //排序形式，name or size or type
        $order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);
        $sorts = array();
        foreach ($file_list as $row) {
            $sorts['size'][] = $row['filesize'];
            $sorts['type'][] = $row['filetype'];
            $sorts['name'][] = $row['filename'];
        }

        if (!empty($file_list)) {
            if($order=='name'){
                array_multisort($sorts['name'], SORT_ASC, $file_list);
            }
            if($order=='size'){
                array_multisort($sorts['size'], SORT_DESC, $file_list);
            }
            if($order=='type'){
                array_multisort($sorts['type'], SORT_ASC, $file_list);
            }
        }

        $result = array();
        //相对于根目录的上一级目录
        $result['moveup_dir_path'] = $moveup_dir_path;
        //相对于根目录的当前目录
        $result['current_dir_path'] = $current_dir_path;
        //当前目录的URL
        $result['current_url'] = $current_url;
        //文件数
        $result['total_count'] = count($file_list);
        //文件列表数组
        $result['file_list'] = $file_list;

        //输出JSON字符串
        return $this->apiResponse($result);
    }





}