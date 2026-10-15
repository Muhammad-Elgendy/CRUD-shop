<?php
// <!-- PHP Developer -->
// <!-- connect PHP with Mysql -->
// <!-- CRUDS -->
// <!-- 
// Server :
// 1- host ? localhost
// 2- user ? root
// 3- password ? 
// 4- database name ? shop
// -->

// Database connection
include_once './env/database.php';

// create OR insert

$message = "";
if (isset($_POST['send'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $insert = "INSERT INTO `customers` VALUES (NULL, '$name ', '$email' , '$gender' , $age) ";
    mysqli_query($connect, $insert);
    $message = "Create Customer Successfuly";
}
//--------------------------

// Select OR Read

    $selcet = "SELECT * FROM customers";
    $customersData = mysqli_query($connect, $selcet);

// Show by ID

if (isset($_GET['show'])) {
    $id = $_GET['show'];
    $selcetbyid = "SELECT * FROM customers WHERE id = $id";
    $onecustomersData = mysqli_query($connect, $selcetbyid);
    $customersviewData = mysqli_fetch_assoc($onecustomersData);
}


// Update or EDIT

$name = null;
$email = null;
$gender = null;
$age = null;
$update = false;
if (isset($_GET['edit'])) {
    $update = true;
    $id = $_GET['edit'];
    $selecetCustomerRow = "SELECT * FROM customers WHERE id = $id";
    $OneSelectCustomerRow = mysqli_query($connect, $selecetCustomerRow);
    $CustomerRow = mysqli_fetch_assoc($OneSelectCustomerRow);
    $name = $CustomerRow['name'];
    $email = $CustomerRow['email'];
    $gender = $CustomerRow['gender'];
    $age = $CustomerRow['age'];

    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $insert = "UPDATE `customers` SET name= '$name ', email=  '$email' , gender= '$gender' , age= $age WHERE id = $id";
        mysqli_query($connect, $update);
        header("location: index.php");
    }
}

// COUNT Customer

$selectcount = "SELECT COUNT(*) as Numberofcustomer FROM customers";
$sc = mysqli_query($connect, $selectcount);
$customercount = mysqli_fetch_assoc($sc);

//DELETE

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = "DELETE FROM customers WHERE id=$id";
    mysqli_query($connect, $delete);
    header("location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/main.css">

</head>

<body>
    <h3 class="my-3 text-center">CRUD PHP <span id="mydate"></span></h3>
    <div class="container col-md-6">
        <div class="card">
            <?php if (!empty($message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert"><?= $message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php endif ?>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <input name="name" value="<?= $name ?>" type="text" class="form-control my-3" placeholder="Enter Customer Name">
                    </div>
                    <div class="form-group">
                        <input name="email" value="<?= $email ?>" type="email" class="form-control my-3" placeholder="Enter Customer Email">
                    </div>
                    <div class="form-group">
                        <select name="gender" type="text" class="form-select my-3">
                            <?php if ($gender == null): ?>
                                <option disabled selected>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            <?php else: ?>
                                <?php if ($gender == "Male"): ?>
                                    <option selected value="male">Male</option>
                                <?php else: ?>
                                    <option selected value="female">Female</option>
                                <?php endif; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input name="age" value="<?= $age ?>" type="number" class="form-control my-3" placeholder="Enter Customer Age">
                    </div>

                    <div class="d-grid">
                        <?php if ($update): ?>
                            <button name="update" class="btn btn-warning"> Update Customer </button>
                        <?php else: ?>
                            <button name="send" class="btn btn-info"> Add Customer </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container col-md-8 mt-5">
        <h6 class="my-3 text-center"> List Your Customer</h6>
        <div class="card">
            <div class="d-grid">
                <button id="deleteAllBtn" class="btn btn danger mb-2 w-50 mx-auto none">delete</button>
            </div>
            <div class="card-body">
                <div id="empty_task_div">
                    <?php if ($customercount['Numberofcustomer'] == 0): ?>
                        <div class="alert alert-danger">
                            Empty Customer
                        </div>
                    <?php else: ?>
                </div>
                <div id="all_tasks">
                    <table class="table table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th colspan="3"> Action</th>
                        </tr>
                        <?php foreach ($customersData as $item): ?>
                            <tr>
                                <th><?= $item['id'] ?></th>
                                <th><?= $item['name'] ?></th>
                                <th><a href="index.php?show=<?= $item['id'] ?>" class="btn btn-info"><i class="fa-solid fa-eye"></i></a></th>
                                <th><a href="index.php?edit=<?= $item['id'] ?>" class="btn btn-warning"><i class="text-info fa-solid fa-pen-to-square"></i></a></th>
                                <th><a href="index.php?delete=<?= $item['id'] ?>" class="btn btn-danger"><i class="text-light fa-solid fa-trash-can"></i></a></th>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['show'])): ?>
        <div class="mymodal">
            <div class="mymodal_content">
                <h6> View Customer : <a class="float-end" href="/php/index.php"><i class="fa-solid fa-rectangle-xmark"></i></a></h6>
                <hr>
                <h6>Customer Name : <?= $customersviewData['name'] ?></h6>
                <hr>
                <h6>Customer Email : <?= $customersviewData['email'] ?></h6>
                <hr>
                <h6>Customer Gender : <?= $customersviewData['gender'] ?></h6>
                <hr>
                <h6>Customer Age : <?= $customersviewData['age'] ?></h6>
                <hr>
            </div>
        </div>
    <?php endif; ?>





    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/main.js"></script>
</body>

</html>