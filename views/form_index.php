<h1>Forms List</h1>

<?php foreach ($forms as $form) : ?>
<div>
    <h3>
        <a href="/forms/view?id=<?= $form['id'] ?>">
            <?= $form['title'] ?>
        </a>
    </h3>
    <p><?= $form['content'] ?></p>
    <p><i>Created at: <?= $form['created_at'] ?></i></p>
    <hr />
</div>
<?php endforeach; ?>

<h2>Create new Form</h2>

<form action="/forms/create" method="POST">
    Title:
    <input type="text" name="form[title]" />
    <br>
    Content:
    <textarea name="form[content]"></textarea>
    <br>
    <input type="submit" value="Create" />
</form>


