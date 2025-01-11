<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
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
                        <i class="fa-brands fa-product-hunt fa-xl"></i>
                        <span class="ml-3">Product</span>
                    </button>

                    <button data-section="section-2"
                        class="nav-item w-full flex items-center p-2 rounded-lg transition-colors duration-200 text-white hover:bg-gray-100 hover:text-gray-900">
                        <i class="fa-solid fa-bag-shopping fa-xl" style="color: #63E6BE;"></i>
                        <span class="ml-3">Tambah barang</span>
                    </button>

                    <button data-section="section-3"
                        class="nav-item w-full flex items-center p-2 rounded-lg transition-colors duration-200 text-white hover:bg-gray-100 hover:text-gray-900">
                        <i class="fa-solid fa-comment" style="color: #B197FC;"></i>
                        <span class="ml-3">Inbox</span>
                    </button>

                    <button data-section="section-4"
                        class="nav-item w-full flex items-center p-2 rounded-lg transition-colors duration-200 text-white hover:bg-gray-100 hover:text-gray-900">
                        <i class="fa-solid fa-chart-simple fa-xl" style="color: #FFD43B;"></i>
                        <span class="ml-3">Statistik</span>
                    </button>

                    <button data-section="section-5"
                        class="nav-item w-full flex items-center p-2 rounded-lg transition-colors duration-200 text-white hover:bg-gray-100 hover:text-gray-900">
                        <i class="fa-solid fa-user fa-xl" style="color: #74C0FC;"></i>
                        <span class="ml-3">Profile</span>
                    </button>

                    <button data-section="section-sign-up" onclick="window.open('./src/auth/register.html', '_blank')"
                        class="nav-item w-full flex items-center p-2 rounded-lg transition-colors duration-200 text-white hover:bg-gray-100 hover:text-gray-900">
                        <i class="fa-solid fa-arrow-right-to-bracket" style="color: #B197FC;"></i>
                        <span class="ml-3">Sign In</span>
                    </button>
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

            <div id="section-3" class="section-content hidden">
                <?php include('./section/inbox.php') ?>
            </div>

            <div id="section-4" class="section-content hidden">
                <section class="py-20">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div
                            class="rounded-2xl py-10 px-10 xl:py-16 xl:px-20 bg-gray-50 flex items-center justify-between flex-col gap-16 lg:flex-row shadow-lg">
                            <div class="w-full lg:w-60">
                                <h2 class="font-manrope text-4xl font-bold text-gray-900 mb-4 text-center lg:text-left">
                                    Our Stats
                                </h2>
                                <p class="text-sm text-gray-500 leading-6 text-center lg:text-left">
                                    Statistik penjualan PKK kelas 11 RPL B
                                </p>
                            </div>
                            <div class="w-full lg:w-4/5">
                                <div class="flex flex-col flex-1 gap-10 lg:gap-0 lg:flex-row lg:justify-between">
                                    <div class="block">
                                        <div
                                            class="font-manrope font-bold text-4xl text-indigo-600 mb-3 text-center lg:text-left">
                                            260+
                                        </div>
                                        <span class="text-gray-900 text-center block lg:text-left">Pesanan
                                        </span>
                                    </div>
                                    <div class="block">
                                        <div
                                            class="font-manrope font-bold text-4xl text-indigo-600 mb-3 text-center lg:text-left">
                                            Rp. 975.000,-
                                        </div>
                                        <span class="text-gray-900 text-center block lg:text-left">
                                            Keuntungan
                                        </span>
                                    </div>
                                    <div class="block">
                                        <div
                                            class="font-manrope font-bold text-4xl text-indigo-600 mb-3 text-center lg:text-left">
                                            72+
                                        </div>
                                        <span class="text-gray-900 text-center block lg:text-left">PO terkirim</span>
                                    </div>
                                    <div class="block">
                                        <div
                                            class="font-manrope font-bold text-4xl text-indigo-600 mb-3 text-center lg:text-left">
                                            89+
                                        </div>
                                        <span class="text-gray-900 text-center block lg:text-left">Orders in
                                            Queue</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-2xl font-bold mb-6">Data Visualization</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Bar Graph -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Bar Graph</h3>
                            <canvas id="barChart"></canvas>
                        </div>
                        <!-- Column Chart -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Horizontal Bar Chart</h3>
                            <canvas id="columnChart"></canvas>
                        </div>
                        <!-- Pie Chart -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Pie Chart</h3>
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </section>

            </div>

            <div id="section-5" class="section-content hidden">
                <section class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
                        <!-- Profile Picture -->
                        <div class="relative w-32 h-32 mx-auto mb-6">
                            <img src="https://via.placeholder.com/128" alt="Profile"
                                class="w-full h-full rounded-full object-cover">
                            <button
                                class="absolute bottom-0 right-0 bg-blue-500 p-2 rounded-full text-white hover:bg-blue-600 transition-colors">
                                <i class="fas fa-pencil-alt text-sm"></i>
                            </button>
                        </div>

                        <!-- Form -->
                        <form method="post | get" class="space-y-6">
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <!-- NISN -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NISN</label>
                                    <input type="text" value="1234567890" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                  focus:border-blue-500 focus:ring-blue-500 
                                                  disabled:bg-gray-50 disabled:text-gray-500" disabled>
                                </div>

                                <!-- Nama -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" value="John Doe" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                  focus:border-blue-500 focus:ring-blue-500 
                                                  disabled:bg-gray-50 disabled:text-gray-500" disabled>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input type="date" value="2000-01-01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                  focus:border-blue-500 focus:ring-blue-500 
                                                  disabled:bg-gray-50 disabled:text-gray-500" disabled>
                                </div>

                                <!-- Nama Kelompok -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Kelompok</label>
                                    <input type="text" value="Kelompok A" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                  focus:border-blue-500 focus:ring-blue-500 
                                                  disabled:bg-gray-50 disabled:text-gray-500" disabled>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end space-x-4">
                                <button type="button" id="editButton" class="inline-flex items-center px-4 py-2 border border-transparent 
                                               rounded-md shadow-sm text-sm font-medium text-white 
                                               bg-blue-500 hover:bg-blue-600 focus:outline-none 
                                               focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-pencil-alt mr-2"></i>
                                    Edit
                                </button>
                                <button type="submit" id="submitButton" class="inline-flex items-center px-4 py-2 border 
                                               border-transparent rounded-md shadow-sm text-sm 
                                               font-medium text-white bg-green-500 hover:bg-green-600 
                                               focus:outline-none focus:ring-2 focus:ring-offset-2 
                                               focus:ring-green-500">
                                    <i class="fas fa-check mr-2"></i>
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>

            <div id="section-sign-up" class="section-content hidden">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-2xl font-bold mb-4">Sign In</h2>
                    <p>Sign in content goes here...</p>
                </div>
            </div>
        </main>
    </div>

    <script>

        // dummy chart
        const barCtx = document.getElementById("barChart").getContext("2d");
        new Chart(barCtx, {
            type: "bar",
            data: {
                labels: ["January", "February", "March", "April", "May"],
                datasets: [
                    {
                        label: "Sales",
                        data: [12, 19, 3, 5, 2],
                        backgroundColor: "rgba(54, 162, 235, 0.5)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
            },
        });

        const columnCtx = document.getElementById("columnChart").getContext("2d");
        new Chart(columnCtx, {
            type: "bar",
            data: {
                labels: ["Product A", "Product B", "Product C", "Product D"],
                datasets: [
                    {
                        label: "Revenue",
                        data: [25, 15, 35, 20],
                        backgroundColor: "rgba(75, 192, 192, 0.5)",
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: { legend: { display: true } },
            },
        });

        const pieCtx = document.getElementById("pieChart").getContext("2d");
        new Chart(pieCtx, {
            type: "pie",
            data: {
                labels: ["Red", "Blue", "Yellow", "Green", "Purple"],
                datasets: [
                    {
                        label: "Population",
                        data: [12, 15, 8, 5, 10],
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.5)",
                            "rgba(54, 162, 235, 0.5)",
                            "rgba(255, 206, 86, 0.5)",
                            "rgba(75, 192, 192, 0.5)",
                            "rgba(153, 102, 255, 0.5)",
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(153, 102, 255, 1)",
                        ],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { position: "top" } },
            },
        });

    </script>
</body>

</html>