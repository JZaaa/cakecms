<?php
namespace Admin\Controller;


use App\Lib\CakeBackup;

class CogsController extends AppController {

    /**
     * 数据库管理
     */
    public function database() {
        $driver = CakeBackup::getInstance();


        if ($this->request->is('post')) {
            return $this->jsonResponse(200, false);
        }

        $data = $driver->getTableStatus();

        $this->set(compact('data'));
    }
}