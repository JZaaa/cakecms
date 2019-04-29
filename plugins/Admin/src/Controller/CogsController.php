<?php
namespace Admin\Controller;


use JZaaa\CakeUtils\Lib\CakeBackup;

class CogsController extends AppController {

    /**
     * 数据库管理
     */
    public function database() {

        $driver = CakeBackup::getInstance();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            switch ($data['type']) {
                case 'bfdb': // 备份数据库
                    $driver->backupDB();
                    break;
                case 'bf': // 备份表
                    $driver->backupTables(explode(',', $data['tables']));
                    break;
                case 'xf': // 修复表
                    $driver->repair(explode(',', $data['tables']));
                    break;
                case 'yh': // 优化表
                    $driver->optimize(explode(',', $data['tables']));
                    break;
            }
            return $this->jsonResponse(200, false);
        }

        $data = $driver->getTableStatus();

        $this->set(compact('data'));
    }


    /**
     * 清除缓存
     * @return \App\Controller\AppController
     */
   public function clearCache()
   {
       $this->clearCacheAll();
       return $this->jsonResponse(200, false);
   }



}