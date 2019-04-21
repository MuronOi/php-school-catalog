<?php

namespace App\Controllers\Api;

use App\Database\Query;
use App\logger\Logger;
use App\Views\JsonView;
use App\Views\RedirectView;
use App\Views\TemplateView;

class FormControllerApi
{
    public function index($params = [])
    {

        $query = new Query;
        $forms = $query->getList("SELECT * FROM forms");

        http_response_code(201);
        return new JsonView(json_encode($forms));
    }


    public function view($get, $post, $bindings)
    {
      //  pd($params);
        $query = new Query();
        $form = $query->getRow(
            "SELECT * FROM forms WHERE id = ?",
            [$bindings['formId']]
        );

//        if (empty($form)) {
//            $message = (sprintf('Id not found. id = %d' , $params['id']));
//            (new Logger)->log($message,'warning');
//            die;
//        }
        http_response_code(201);

        return new JsonView(json_encode($form));
    }

    public function create($params, $post)
    {
        $query = new Query();
        $query->execute(
            "INSERT INTO forms (title, content) VALUES (?, ?)",
            [$post['title'], $post['content']]
        );

        $id = $query->getLastInsertId();

        return $this->view([], [], ['formId' => $id]);
    }

    public function update($get, $put, $params, $bindings)
    {
        p($params);
        p($bindings);
        (new Query)->execute("UPDATE forms SET title = ?, content = ? WHERE id = ?",
            [$params['title'], $params['content'], $bindings['formId']]);
        return 'opa';
    }
    public function delete($get, $params, $bindings)
    {
        (new Query)->execute("DELETE FROM forms WHERE id = ?", [$bindings['formId']]);

        return 'ok';
    }
}