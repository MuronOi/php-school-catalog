
<div>
    <h1><?= $form['title'] ?></h1>
    <p><?= $form['content'] ?></p>
    <p><i>Created at: <?= $form['created_at'] ?></i></p>

    <p><a href="/forms/delete?id=<?= $form['id'] ?>">Delete this form</a></p>
    <p><a href="/forms">Return to forms list</a></p>

</div>
