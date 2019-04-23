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
    /**
     * @param array $params
     * @return JsonView
     */
    public function index($params = [])
    {
        $query = new Query;
        $forms = $query->getList("SELECT * FROM forms");

        return new JsonView($forms);
    }
    /**
     * @param $get
     * @param $putData
     * @param $bindings
     * @return JsonView
     */
    public function view($get, $putData, $bindings)
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
    /**
     * @param $params
     * @param $post
     * @return JsonView
     */
    public function create($params, $post, $bindings)
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
    /**
     * @param $get
     * @param $params
     * @param $bindings
     * @return JsonView
     */
    public function update($get, $params, $bindings)
    {
        $query = new Query();
        $query->execute("UPDATE forms SET title = ?, content = ? WHERE id = ?",
            [$params['title'], $params['content'], $bindings['formId']]);

        $form = $query->getRow("SELECT * FROM forms WHERE id = ?", [$bindings['formId']]);
        return new JsonView($form);
    }
    /**
     * @param $get
     * @param $params
     * @param $bindings
     * @return JsonView
     */
    public function delete($get, $params, $bindings)
    {
        (new Query)->execute("DELETE FROM forms WHERE id = ?", [$bindings['formId']]);
        $query = new Query;

        return new JsonView([], ["Form {$bindings['formId']} deleted"], 204);
    }
}