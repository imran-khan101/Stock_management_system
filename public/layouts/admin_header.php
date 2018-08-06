<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/favicon.png">

    <title>Stock Management System</title>

    <!-- Bootstrap core CSS -->
    <link href="../stylesheets/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../stylesheets/sticky-footer-navbar.css" rel="stylesheet">

    <!--JQuery UI-->
    <link rel="stylesheet" href="../stylesheets/jquery-ui.min.css">

    <script src="../js/jquery-3.1.1.js"></script>
</head>

<body>

<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="index.php">Stock Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Setup
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="setup_item.php">Setup an Item</a>
                        <a class="dropdown-item" href="setup_company.php">Setup a Company</a>
                        <a class="dropdown-item" href="setup_category.php">Setup a Category</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Stock
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="stock_in.php">Stock In</a>
                        <a class="dropdown-item" href="stock_out.php">Stock Out</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="item_summary.php">Item Summary</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sales_view.php">View Sales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>

            </ul>
            <!--<form class="form-inline ">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>-->
            <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
                <li class="nav-item dropdown">
                    <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo User::current_user()->full_name(); ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
                        <a class="dropdown-item" href="logout.php">Logout</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="https://v4-alpha.getbootstrap.com/">v4 Alpha 6</a>
                        <a class="dropdown-item" href="https://getbootstrap.com/docs/3.3/">v3.3.7</a>
                        <a class="dropdown-item" href="https://getbootstrap.com/2.3.2/">v2.3.2</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Begin page content -->
<main role="main" class="container">