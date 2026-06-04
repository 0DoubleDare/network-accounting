<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../../controllers/networckPointControler.php" method="post" enctype="multipart/form-data">
    
    <label>Название сетевой точки</label><br>
    <input type="text" name="label"><br><br>

    <label>Тип</label><br>
    <select name="type">
        <option value="socket">socket</option>
        <option value="switch">switch</option>
        <option value="cable_run">cable_run</option>
        <option value="patch_cord">cable_run</option>
    </select><br><br>

    <label>Локация</label><br>
    <input type="text" name="location"><br><br>

    <label>Статус</label><br>
    <select name="status">
        <option value="active">active</option>
        <option value="defect">defect</option>
        <option value="decommissioned">decommissioned</option>
    </select><br><br>

    <label>Фотография сетевой точки</label><br>
    <input type="file" name="image_path"><br><br>

    <button type="submit">Добавить</button>

    </form>
</body>
</html>