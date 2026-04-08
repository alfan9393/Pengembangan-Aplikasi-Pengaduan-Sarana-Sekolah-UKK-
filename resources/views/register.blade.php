<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e3f2fd;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 320px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #2196f3;
        }

        .alert {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input:focus, select:focus {
            border-color: #2196f3;
            outline: none;
        }

        select {
            background-color: white;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #2196f3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
        }

        button:hover {
            background-color: #1976d2;
        }

        p {
            margin-top: 15px;
            font-size: 14px;
        }

        a {
            color: #fdfeff;
            text-decoration: none;
            font-weight: bold;
            margin-left: 5px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body>

    <div class="container">
        <h2>Register</h2>

        @if(session('error'))
            <div class="alert">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <input type="text" name="nis" placeholder="NIS" required>
            
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            
            <input type="text" name="username" placeholder="Username" required>
            
            <input type="password" name="password" placeholder="Password" required>
            
            <input type="text" name="telp" placeholder="Nomor Telepon">

            <input type="text" name="kelas" placeholder="Kelas">

            <select name="role">
                <option value="siswa">Siswa</option>
                <option value="admin">Admin</option>
            </select>

            <input type="text" name="kode_admin" placeholder="Kode Admin (isi jika admin)">

            <button type="submit">Daftar Akun</button>
        </form>

        <p>Sudah punya akun?<a href="/login">Login disini</a></p>
    </div>

</body>
</html>