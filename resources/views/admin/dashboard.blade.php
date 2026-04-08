<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #e3f2fd; 
        }

        .navbar {
            background-color: #2196f3; 
            padding: 15px;
            color: white;
        }

        .navbar h2 {
            margin: 0;
        }

        .navbar a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 20px;
        }

        h3 {
            color: #000000;
        }

        .stat {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            flex: 1;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .stat-item b {
            display: block;
            margin-top: 10px;
            font-size: 20px;
            color: #000000;
        }
    </style>

</head>
<body>

    <div class="navbar">
        <h2>Dashboard Admin</h2>
        
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/laporan">Laporan</a>
        <a href="/logout">Logout</a>
    </div>

    <div class="container">

        <h3>Statistik Pengaduan</h3>

        <div class="stat">
            <div class="stat-item">
                Belum Dibaca
                <b>{{ $belum }}</b>
            </div>
            <div class="stat-item">
                Proses
                <b>{{ $proses }}</b>
            </div>
            <div class="stat-item">
                Selesai
                <b>{{ $selesai }}</b>
            </div>
        </div>

    </div>

</body>
</html>