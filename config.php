<?php
$pdo = new PDO('mysql:host=localhost;dbname=crud;charset=utf8','root','');
$page = isset($_GET['p'])?$_GET['p']:'';
if($page == 'add') {

    $name = strip_tags(trim($_POST['name']));
    $price = strip_tags(trim($_POST['price']));;
    $rating = strip_tags(trim($_POST['rating']));
    $stmt = $pdo->prepare('INSERT INTO products (id, name, price, rating) VALUES (null, ?, ?, ?)');

    $stmt->execute(array($name, $price, $rating));
}else if ($page == 'edit'){
    $id = strip_tags(trim($_POST['id']));
    $name = strip_tags(trim($_POST['name']));
    $price = strip_tags(trim($_POST['price']));;
    $rating = strip_tags(trim($_POST['rating']));
    $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, rating = ? WHERE id = ?');
    $stmt->execute(array($name, $price, $rating, $id));
}else if ($page == 'del'){
    $id = $_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute(array($id));
}else{
    $stmt = $pdo->prepare('SELECT * FROM products');
    $stmt->execute();
    while ($row = $stmt->fetch()){
        ?>
<tr>
    <td><?=$row['id'] ?></td>
    <td><?=$row['name'] ?></td>
    <td><?=$row['price'] ?></td>
    <td><?=$row['rating'] ?></td>
    <td>
        <button class="btn-success" data-toggle="modal" data-target="#edit-<?=$row['id'] ?>">Edit</button>
        <!-- Modal -->
        <div class="modal fade" id="edit-<?=$row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editLabel-<?=$row['id'] ?>">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editLabel-<?=$row['id'] ?>">Edit Data</h4>
                    </div>
                    <form>
                        <div class="modal-body">
                            <input type="hidden" id="<?=$row['id'] ?>">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name-<?=$row['id'] ?>" name="name" value="<?=$row['name'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price-<?=$row['id'] ?>" name="price" value="<?=$row['price'] ?>" ">
                            </div>
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <input type="number" class="form-control" id="rating-<?=$row['id'] ?>" name="rating" value="<?=$row['rating'] ?>">
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" onclick="updateDate(<?=$row['id'] ?>)" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <button type="submit" onclick="deleteData(<?=$row['id'] ?>)" class="btn-danger">Delete</button>
    </td>
</tr>
<?php
    }
}
