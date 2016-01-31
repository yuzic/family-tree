<?php
namespace App\Controller;

use \Aqua\Base\Request;
use \App\Base\Helper\Captcha;
use \App\Base\Helper\Protection;

class Index extends \Aqua\Base\Controller
{

    public function index($page = 1)
    {
        $page = (int) $page;
        $sortField =  Request::get('field', 'created_at');
        $orderMethod  = strtoupper(Request::get('order', 'desc'));
        $notify = ['error' => null, 'message' => null];
        $comment =  new \App\Model\Comment;

        try {

            if (Request::post('comment')) {
                $name = Request::post('name');
                $email = Request::post('email');
                $homepage = Request::post('homepage');
                $captcha = Request::post('captcha');
                $csrToken = Request::post('csrf_token');
                $ip = Request::getIp();
                $agent = Request::getUseAgent();
                $message = Request::post('message');

                if (!Protection::validateCsrfToken($csrToken)) {
                    throw new \Exception('Error token validation');
                }

                if (empty($name)) {
                    throw new \Exception('Empty name');
                }

                if (!Captcha::validate($captcha)) {
                    throw new \Exception('Error validate captcha');
                }

                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception('Email not valid');
                }

                if (!empty($homepage)
                    && !filter_var($homepage, FILTER_VALIDATE_URL)) {
                    throw new \Exception('Homepage is not valid');
                }

                if (empty($message)) {
                    throw new \Exception('Empty message');
                }


                $params = [
                    'name' => $name,
                    'email' => $email,
                    'homepage' => $homepage,
                    'ip' => $ip,
                    'agent' => $agent,
                    'message' => $message,
                    'created_at' => time(),
                ];

                if (!$comment->save($params)) {
                    throw new \Exception('Error save comment');
                }

                $notify['message'] = 'Comment success add';

                unset($_POST);
            }


        } catch (\Exception $e) {
            $notify['error']  =  $e->getMessage();
        }

        $commentList = [];

        try {
            if (!in_array($sortField, $comment->sortListAllow)) {
                throw new \Exception('Error validate field');
            }

            if (!in_array($orderMethod, $comment->orderListAllow)) {
                throw new \Exception('Error validate order parametr');
            }

            $commentList = $comment->commentList($page, $sortField, $orderMethod);
        } catch (\Exception $e) {
            $notify['error']  =  $e->getMessage();
        }

        $this->render('index', [
            'commentList' => $commentList,
            'commentCount' => $comment->getCount()['count'],
            'pageCount' =>  \App\Model\Comment::PAGE_COUNT,
            'page' =>  $page,
            'notify' => $notify
        ]);
    }


    public function lists()
    {
        $family = new  \App\Model\FamilyTree;

        $list = $family->lists();

        $new_list = [];

        foreach ($list as  $value) {
            if ($value['parent_id'] == null) {
               $value['parent_id'] = 0;
            }
            $new_list[] = "[{$value['id']}, {$value['parent_id']}, \"{$value['name']}\"]";
        }
        

        echo '[' . implode(',', $new_list) .']';   



        //echo json_encode($list);

       // echo '[[1,0,"1111"], [2,0,"2222"], [3,0,"3333"], [4,2,"child"]]';

    }



    public function add()
    {
       $family = new  \App\Model\FamilyTree;

       $params  = [
            'name'  => Request::post('name'),
            'parent_id'  => Request::post('parent_id'),
            'created_at'    => time(),

       ];
       $family->add($params);
    }

}
