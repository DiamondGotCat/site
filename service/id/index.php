<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamu Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto">
        <h1 class="text-center text-4xl mt-10">Kamu Account</h1>

        <!-- Register Form -->
        <div class="max-w-md mx-auto mt-10 bg-gray-800 p-5 rounded">
            <h2 class="text-2xl mb-4">Register</h2>
            <form action="register.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium">Username</label>
                    <input type="text" id="username" name="username" required class="w-full p-2 bg-gray-700 text-white rounded">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" required class="w-full p-2 bg-gray-700 text-white rounded">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" required class="w-full p-2 bg-gray-700 text-white rounded">
                </div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Register</button>
            </form>
        </div>

        <!-- Login Form -->
        <div class="max-w-md mx-auto mt-10 bg-gray-800 p-5 rounded">
            <h2 class="text-2xl mb-4">Login</h2>
            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium">Username</label>
                    <input type="text" id="username" name="username" required class="w-full p-2 bg-gray-700 text-white rounded">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" required class="w-full p-2 bg-gray-700 text-white rounded">
                </div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</button>
            </form>
        </div>
    </div>
</body>
</html>