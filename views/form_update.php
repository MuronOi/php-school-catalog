
<h1>Update Form <?= $form['id'] ?></h1>

<form action="/forms/update" method="POST">
    Title:
    <input type="text" name="form[title]" value=<?= $form['title'] ?> />
    <br>
    Content:
    <textarea name="form[content]"><?= $form['content'] ?></textarea>
    <br>
    <input type="submit" value="Update" />
</form>
<div>

    <p><a href="/forms">Return to forms list</a></p>

</div>
