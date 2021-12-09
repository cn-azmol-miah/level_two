<?php
require('../config/db.php');
require('../config/config.php');
session_start();

// Pagination
$rpp = 6;
// Query
require('../config/all_products_query.php');

$all_products_page = 'index.php';
?>

<!-- Header and Search Includes -->
<?php include("../inc/admin-header.php"); ?>
<?php include("../inc/search.php"); ?>

<?php if (isset($_SESSION['admin-logedIn']) && $_SESSION['admin-logedIn'] === true) : ?>

    <h4 class="text-reset">Welcome <span id="username" class="badge bg-success"><?php echo $_SESSION['admin']; ?></span></h4>
    <div class="d-flex justify-content-between align-items-end mt-5 mb-4">
        <a href="create.php" class="btn btn-outline-primary btn-block"><i class="fas fa-plus"></i> Create Product</a>
        <form action="<?php $_SERVER['PHP_SELF'];  ?>" autocomplete="off" class="form-horizontal" method="post" accept-charset="utf-8">
            <div class="input-group">
                <input name="search" class="form-control" type="text" placeholder="Search Here">
                <button class="input-group-text" name="submit" type="submit" id="addressSearch"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>

    <?php echo $search_results_message; ?>

    <table class="table" style="vertical-align: middle;">
        <thead>
            <tr>
                <th scope="col">#id</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>


        <?php if ($search_findings == [] && $search_results_message == '') : ?>
            <tbody>
                <?php foreach ($products as $product) :  ?>
                    <tr class="wow animate__animated animate__fadeIn">
                        <th scope="row"><?php print_r($product['id']) ?></th>
                        <td><img src="<?php print_r('../' . $product['image']) ?>" alt="" style="width:50px;height:55px;"></td>
                        <td><?php print_r($product['title']) ?></td>
                        <td>£<?php print_r($product['price']) ?></td>
                        <td><?php print_r($product['created_at']) ?></td>
                        <td>
                            <a href="<?php echo ROOT_URL; ?>admin/edit.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i> Edit</a>

                            <form method="POST" action="delete.php" class="d-inline">
                                <input type="hidden" name="delete_id" value="<?php print_r($product['id']); ?> ">
                                <button type="submit" name="delete" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        <?php else : ?>
            <tbody>
                <?php foreach ($search_findings as $i => $finding) : ?>
                    <tr class="wow animate__animated animate__fadeIn">
                        <th scope="row"><?php echo $i + 1 ?></th>
                        <td><img src="<?php print_r('../' . $finding['image']) ?>" alt="" style="width:50px;height:55px;"></td>
                        <td><?php print_r($finding['title']) ?></td>
                        <td>£<?php print_r($finding['price']) ?></td>
                        <td><?php print_r($finding['created_at']) ?></td>
                        <td>
                            <a href="<?php echo ROOT_URL; ?>edit.php?id=<?php echo $finding['id']; ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i> Edit</a>

                            <form method="POST" action="delete.php" class="d-inline">
                                <input type="hidden" name="delete_id" value="<?php print_r($finding['id']); ?> ">
                                <button type="submit" name="delete" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        <?php endif; ?>
    </table>
    <?php if ($search_findings == [] && $search_results_message == '') : ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php for ($x = 1; $x < $total_pages + 1; $x++) : ?>
                    <li class="page-item"><?php echo "<a class='page-link' href='?page=$x'>$x</a>"; ?></li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-danger my-5" role="alert">You are not logged in. Visit the <a href="login.php">admin login</a> page to sign in.</div>
<?php endif; ?>

<?php include("../inc/footer.php"); ?>