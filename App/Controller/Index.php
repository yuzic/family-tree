<?php
namespace App\Controller;

use \Aqua\Base\Request;
use \App\Base\Helper\Html;

class Index extends \Aqua\Base\Controller
{

    public function index()
    {
       
    }


    public function getList()
    {
        $notify = ['error' => null, 'message' => null];

        try {
            $family = new  \App\Model\FamilyTree;
            $list = $family->getList();

            if (!is_array($list)) {
                throw new \Exception('Empty list');
            }


            $treeList = [];
            foreach ($list as  $value) {
                $value['name'] = Html::escape($value['name']);
                $treeList[] = "[{$value['id']}, {$value['parent_id']}, \"{$value['name']}\"]";
            }

            if (empty($treeList)) {
                throw new \Exception('Empty tree');
            }

        } catch (\Exception $e) {
            $notify['error']  =  $e->getMessage();
        }

        
        $this->render('list', [
            'treeList' => $treeList,
            'notify'    => $notify,

        ]);

 

    }



    public function add()
    {
       try {

           $family = new  \App\Model\FamilyTree;
           $name = Request::post('name');
           $parent_id = (int) Request::post('parent_id');

            if (empty($name)) {
                throw new \Exception('Empty name');
            }

            if (empty($parent_id)) {
                throw new \Exception('Empty parent id');
            }

           $params  = [
                'name'  => Html::escape($name),
                'parent_id'  => $parent_id,
                'created_at'    => time(),

           ];

           if (!$family->add($params)) {
                 throw new \Exception('Error add family');
           }

           $notify['message']  = 'Add family success';


        } catch (\Exception $e) {
            $notify['error']  =  $e->getMessage();
        }


        header("Content-type: application/json");
        $this->render('add', [
            'notify'    => $notify,

        ]);

    }


    public function delete()
    {
       try {

           $family = new  \App\Model\FamilyTree;
           $id = (int) Request::post('id');

            if (empty($id)) {
                throw new \Exception('Empty id');
            }

            if (!$family->delete($id)) {
                 throw new \Exception('Error delete family');
            }

           $notify['message']  = 'delete family success';


        } catch (\Exception $e) {
            $notify['error']  =  $e->getMessage();
        }

        header("Content-type: application/json");
        $this->render('add', [
            'notify'    => $notify,
        ]);

    }

}
