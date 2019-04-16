<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Roles Controller
 *
 * @property \Admin\Model\Table\RolesTable $Roles
 *
 * @method \Admin\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{

    public function index()
    {
        $this->setPage();

        $conditions = [];

        if (!empty($name = $this->request->getQuery('name'))) {
            $conditions['name'] = $name;
        }

        $query = $this->Roles->find()
            ->where($conditions);

        $data = $this->paginate($query);

        $this->set(compact('data', 'name'));
    }
}
