<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$photoPath = 'assets/user.png';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sidenav Light - SB Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">


    <style>
    /* Font utama seluruh halaman */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    /* Navbar atas */
    .sb-topnav {
        background: linear-gradient(to right, #667eea, #764ba2);
        color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
        font-weight: 600;
        color: #fff !important;
        font-size: 1rem;
        transition: 0.3s;
    }

    .navbar-brand:hover {
        color: #ffd369 !important;
        transform: scale(1.03);
    }

    .navbar-brand img {
        border: 2px solid #fff;
        padding: 1px;
        background-color: #fff;
    }

    /* Sidebar gradasi elegan */
    .sb-sidenav-gradient {
        background: linear-gradient(to bottom right, #1f1c2c, #928dab);
        color: #fff;
    }

    .sb-sidenav-gradient .nav-link {
        color: #e0e0e0;
        font-size: 0.95rem;
        font-weight: 500;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .sb-sidenav-gradient .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.08);
        color: #fff;
        transform: translateX(4px);
    }

    .sb-sidenav-gradient .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        border-left: 4px solid #ffd369;
        color: #fff;
    }

    .sb-nav-link-icon {
        color: #ffd369;
        margin-right: 8px;
    }

    .sb-sidenav-menu-heading {
        text-transform: uppercase;
        font-size: 0.75rem;
        color: #cccccc;
        margin: 20px 20px 10px;
    }

    .sb-sidenav-footer {
        background-color: rgba(0, 0, 0, 0.15);
        font-size: 0.85rem;
        color: #ccc;
        padding: 1rem;
        font-style: italic;
    }

    /* Dropdown user kanan */
    .navbar-nav .nav-link {
        color: #fff !important;
    }

    .dropdown-menu {
        font-size: 0.9rem;
    }
    </style>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark"
        style="background: linear-gradient(to right, #1f1c2c, #928dab);">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 d-flex align-items-center gap-2" href="profile.php" title="Lihat Profil">
            <img src="<?php echo $photoPath; ?>" alt="User" class="rounded-circle"
                style="height: 30px; width: 30px; object-fit: cover;">
            <?php echo htmlspecialchars($username); ?>
        </a>


        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar-->
        <ul class="navbar-nav flex-grow-1 justify-content-end me-3 me-lg-4">
            <!-- flex-grow-1 and justify-content-end to align right -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="controller/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-gradient" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- Archive Link -->
                        <div class="sb-sidenav-menu-heading">Arsip</div>
                        <a class="nav-link" href="archive.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                            PIDUM
                        </a>

                        <a class="nav-link" href="archive-pidsus.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                            PIDSUS
                        </a>

                        <!-- Manage Users Link (Visible only for Superadmin) -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin') { ?>

                        <a class="nav-link" href="users.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Manage Users
                        </a>

                        <a class="nav-link" href="rekap.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                            Rekap Arsip
                        </a>
                        <?php } ?>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:
                        <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">