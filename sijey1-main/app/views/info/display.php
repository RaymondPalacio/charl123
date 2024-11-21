<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .pagination a {
            margin: 0 3px;
        }
        .container {
            margin-top: 15px;
        }
    </style>

</head>
<?php
include 'dbcon.php';
$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$total_stmt = $pdo->prepare("SELECT COUNT(*) FROM cjwa_users WHERE cjwa_last_name LIKE ? OR cjwa_first_name LIKE ?");
$total_stmt->execute(["%$search%", "%$search%"]);
$total_rows = $total_stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT * FROM cjwa_users WHERE cjwa_last_name LIKE ? OR cjwa_first_name LIKE ? LIMIT ? OFFSET ?");
$stmt->execute(["%$search%", "%$search%", $limit, $offset]);
$user = $stmt->fetchAll();

$total_pages = ceil($total_rows / $limit);
?>

<body>
   <div class="container">
        <div class="row mx-auto mt-3">
            <div class="col-md-8">
                <h4><?=$name;?></h4>
                <a class="btn btn-primary mb-2" role="button" href="<?=site_url('info/add');?>">Add</a>
                <?php flash_alert(); ?>
                <table class="table table-bordered table-stripped">
                    <tr>
                        <th>ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Address</th>
                    </tr>
                    <?php foreach($information as $i): ?>
                    <tr>
                        <td><?=$i['id'];?></td>
                        <td><?=$i['cjwa_last_name'];?></td>
                        <td><?=$i['cjwa_first_name'];?></td>
                        <td><?=$i['cjwa_email'];?></td>
                        <td><?=$i['cjwa_gender'];?></td>
                        <td><?=$i['cjwa_address'];?></td>
                        <td>
                            <a href="<?=site_url('info/update/'.$i['id']);?>">Update</a> |
                            <a href="<?=site_url('info/delete/'.$i['id']);?>">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?search=<?php echo htmlspecialchars($search); ?>&page=<?php echo $i; ?>" class="btn btn-sm btn-secondary"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            document.getElementById('search-form').submit();
        });
    </script>
</body>
</html>