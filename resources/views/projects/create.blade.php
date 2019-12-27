<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
</head>
<body>
    <h1>Create a Project</h1>
    <form method="POST" action="/projects">
        @csrf
        <div class="field">
            <label for="title" class="label">Title</label>
            <div class="control">
                <input type="text" class="input" name="title">
            </div>
        </div>
        <div class="field">
            <label for="description" class="label">Description</label>
            <div class="control">
                <textarea type="text" class="textarea" name="description"></textarea>
            </div>
        </div>
        <button type="submit" class="button">Create a Project</button>
    </form>
</body>
</html>