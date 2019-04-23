<?php

namespace App\Controllers\Api;

use App\Database\Query;
use App\logger\Logger;
use App\Views\JsonView;
use App\Views\RedirectView;
use App\Views\TemplateView;

/**
 * Class FormControllerApi
 * @package App\Controllers\Api
 */
class FormControllerApi
{
    public function index($params = [])
    {
        $query = new Query;
        $forms = $query->getList("SELECT * FROM forms");

        return new JsonView($forms);
    }

    public function view($get, $postData, $putData, $bindings)
    {
        $query = new Query();
        $form = $query->getRow(
            "SELECT * FROM forms WHERE id = ?",
            [$bindings['formId']]
        );

        if (empty($form)) {
            $message = (sprintf('Id not found. id = %d' , $bindings['formId']));
            (new Logger)->log($message,'warning');
            http_response_code(404);
            die;
        }

        return new JsonView($form);
    }

    public function create($params, $post)
    {
        $query = new Query();
        $query->execute(
            "INSERT INTO forms (title, content) VALUES (?, ?)",
            [$post['title'], $post['content']]
        );

        $id = $query->getLastInsertId();

        $form = $query->getRow("SELECT * FROM forms WHERE id = ?", [$id]);

        return new JsonView($form, ['Form created'], 201 );
    }

    public function update($get, $put, $params, $bindings)
    {
        $query = new Query();
        $query->execute("UPDATE forms SET title = ?, content = ? WHERE id = ?",
            [$params['title'], $params['content'], $bindings['formId']]);

        $form = $query->getRow("SELECT * FROM forms WHERE id = ?", [$bindings['formId']]);
        return new JsonView($form);
    }

    public function delete($get, $put, $params, $bindings)
    {
        (new Query)->execute("DELETE FROM forms WHERE id = ?", [$bindings['formId']]);

        return new JsonView('', [], 204);
    }
}