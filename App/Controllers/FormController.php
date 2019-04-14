<?php

namespace App\Controllers;

use App\Database\Query;
use App\logger\Logger;
use App\Views\RedirectView;
use App\Views\TemplateView;

class FormController
{
    private $logger;

    public function __construct()
    {
        $this->logger = new Logger();
    }

    public function index($params = [])
    {

        $query = new Query;
        $forms = $query->getList("SELECT * FROM forms");

        //$this->logger->log()
        return new TemplateView('form_index', [
            'title' => 'My awesome page',
            'forms' => $forms
        ]);
    }

    public function view($params = [])
    {
        $query = new Query();
        $form = $query->getRow(
            "SELECT * FROM forms WHERE id = ?",
            [$params['id']]
        );

        if (empty($form)) {
            $message = (sprintf('Id not found. id = %d' , $params['id']));
            (new Logger)->log($message,'warning');
            die;
        }

        return new TemplateView('form_view', [
            'form' => $form
        ]);
    }

    public function create($params, $post)
    {
        $query = new Query();
        // $query->execute(
        //     "INSERT INTO forms (title, content) VALUES (?, ?)",
        //     [$post['form']['title'], $post['form']['content']]
        // );

        $query->execute(
            "INSERT INTO forms (title, content) VALUES (:title, :content)",
            $post['form']
        );

        $id = $query->getLastInsertId();

        return new RedirectView('/forms/view?id=' . $id);
    }

    public function delete($params)
    {
        (new Query)->execute("DELETE FROM forms WHERE id = ?", [$params['id']]);
        return new RedirectView('/forms');
    }

    public function update ($params)
    {
        return new TemplateView( 'form_update', ['form' => $params]);
    }

    public function updatePost($get, $params)
    {
        (new Query)->execute("UPDATE forms SET title = :title, content = :content WHERE id = :id", $params['form']);
        return new RedirectView('/forms/view?id=' . $params['form']['id']);
    }
}
