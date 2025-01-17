<?php
    session_start();

    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('location: index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/styles/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="./src/script/dashboard.js"></script>   
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0">
            <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                <div class="flex items-center mb-5 gap-2">
                    <i class="fa-solid fa-shop fa-xl" style="color: #74C0FC;"></i>
                    <span class="text-xl font-semibold dark:text-white">Dashboard Kasir</span>
                </div>

                <nav class="space-y-2">
                    <button data-section="section-1"
                        class="nav-item w-full flex items-center p-2 rounded-lg transition-colors duration-200 text-white hover:bg-gray-100 hover:text-gray-900 active:text-gray-900">
                        <i class="fa-brands fa-product-hunt"></i>
                        <span class="ml-3">Product</span>
                    </button>

                    <button data-section="section-2"
                        class="nav-item w-full flex items-center p-2 rounded-lg transition-colors duration-200 text-white hover:bg-gray-100 hover:text-gray-900">
                        <i class="fa-solid fa-bag-shopping" style="color: #63E6BE;"></i>
                        <span class="ml-3">Tambah barang</span>
                    </button>

                    <a href="section/kasir.php"><button data-section="section-3"
                        class="nav-item w-full flex items-center p-2 rounded-lg transition-colors duration-200 text-white hover:bg-gray-100 hover:text-gray-900">
                        <i class="fa-solid fa-comment" style="color: #B197FC;"></i>
                        <span class="ml-3">Pesan</span>
                    </button>
                    </a>

                    <button data-section="section-4"
                        class="nav-item w-full flex items-center p-2 rounded-lg transition-colors duration-200 text-white hover:bg-gray-100 hover:text-gray-900">
                        <i class="fa-solid fa-comments-dollar" style="color: cyan;"></i>
                        <span class="ml-3">Pendapatan</span>
                    </button>
                    <form action="dashboard.php" method="POST">
                        <button data-section="section-sign-up" type="submit" name="logout"
                            class="nav-item w-full flex items-center p-2 rounded-lg transition-colors duration-200 text-white hover:bg-gray-100 hover:text-gray-900">
                            <i class="fa-solid fa-arrow-right-to-bracket" style="color: #B197FC;"></i>
                            <span class="ml-3">Log Out</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Mobile menu button -->
        <button id="mobile-menu-button" class="md:hidden fixed top-4 left-4 z-50 p-2 rounded-md bg-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Main Content -->
        <main class="flex-1 p-4 overflow-auto">
            <div id="section-1" class="section-content">
                <?php include('./section/order.php') ?>
            </div>

            <div id="section-2" class="section-content hidden">
                <div class="bg-white p-1 rounded-lg shadow">
                    <?php include('./section/tambahBarang.php') ?>
                </div>
            </div>

            <div id="section-4" class="section-content hidden">
                <div class="bg-white p-1 rounded-lg shadow">
                    <?php include('./section/pendapatan.php') ?>
                </div>
            </div>

            

            <div id="section-sign-up" class="section-content hidden">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-2xl font-bold mb-4">Log Out</h2>
                    <p>Sedang proses untuk log out, harap tunggu...</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        function openUpdateModal(id, name, price, stock, type) {
            document.getElementById('modalIdProduct').value = id;
            document.getElementById('modalName').value = name;
            document.getElementById('modalPrice').value = price;
            document.getElementById('modalStock').value = stock;
            document.getElementById('modalType').value = type;
            document.getElementById('updateModal').classList.remove('hidden');
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }
    </script>
</body>

</html>