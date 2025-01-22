<?php 
    include "services/database.php";
    session_start();

    $loginMessage = "";

    // Arahkan ke dashboard kalo udah login
    if (isset($_SESSION["is_login"])) {
        header("location: dashboard.php");
        exit;
    }

    // Proses login
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hash_password = hash("sha256", $password);

        // Gunakan prepared statement untuk mencegah SQL injection
        $sql = "SELECT * FROM admin WHERE USERNAME_ADMIN = ? AND PASSWORD = ?";
        
        // Siapkan statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameter
            $stmt->bind_param("ss", $username, $hash_password);
            
            // Eksekusi query
            $stmt->execute();
            
            // Ambil hasil
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $_SESSION["username"] = $data["username"];
                $_SESSION["is_login"] = true;

                $stmt->close();
                $conn->close();
                
                header("location: dashboard.php");
                exit;
            } else {
                $loginMessage = "Akun tidak ditemukan atau password salah.";
            }
            
            $stmt->close();
        } else {
            $loginMessage = "Terjadi kesalahan dalam sistem.";
        }
        
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="./src/styles/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="src/image/marketopia_logo.jpg" type="image/x-icon">
</head>

<body class="bg-cyan-500 min-h-screen flex items-center justify-center">
    <section class="flex h-[100vh] w-[100vw]">
        <div class="left-side m-auto flex justify-center align-center w-[50%]">
            <img src="src/image/marketopia_logo.png" alt="">
        </div>
        <div class="right-side w-[50%] m-auto flex justify-center align-center">
            <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6 relative right-12">
                <h3 class="text-2xl font-bold text-gray-800 text-center mb-6">Login Form</h3>
        
                <!-- Error message -->
                <?php if (!empty($loginMessage)) : ?>
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                        <?= htmlspecialchars($loginMessage) ?>
                    </div>
                <?php endif; ?>
        
                <!-- Form Login -->
                <form action="" method="post" class="space-y-4">
                    <div>
                        <label for="username" class="block text-gray-700 font-medium mb-1">Username</label>
                        <input type="text" id="username" name="username"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div>
                        <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" name="login"
                        class="w-full bg-teal-500 text-white font-medium py-2 rounded hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>

    <script>
        function handleLogin() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');

            // Reset error message
            errorMessage.textContent = '';
            errorMessage.classList.add('hidden');

            if (!username || !password) {
                showErrorMessage('Please fill in all fields.');
                return;
            }

            // Simulate login validation
            if (username === 'admin' && password === 'admin123') {
                alert('Login successful!');
                // Example: Redirect to another page
                window.location.href = "dashboard.php";
            } else {
                showErrorMessage('Invalid username or password.');
            }
        }

        function showErrorMessage(message) {
            const errorMessage = document.getElementById('error-message');
            errorMessage.textContent = message;
            errorMessage.classList.remove('hidden');
        }
    </script>
</body>
</html>