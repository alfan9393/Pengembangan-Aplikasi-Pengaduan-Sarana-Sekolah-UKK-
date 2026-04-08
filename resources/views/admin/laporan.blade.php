<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan</title>

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

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        th {
            background-color: #2196f3;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f9ff;
        }

        button {
            background-color: #2196f3;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1976d2;
        }
    </style>

</head>
<body>

    <div class="navbar">
        <h2>Data Laporan Pengaduan</h2>

        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/laporan">Laporan</a>
        <a href="/logout">Logout</a>
    </div>

    <div class="container">

        <table>
            <thead>
                <tr>
                    <th>Isi Laporan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                    <tr>
                        <td>{{ $d->isi_laporan }}</td>

                        <td>
                            @if($d->status == '0')
                                Menunggu
                            @elseif($d->status == 'proses')
                                Proses
                            @elseif($d->status == 'selesai')
                                Selesai
                            @endif
                        </td>

                        <td>
                            @if($d->status == '0')
                                <a href="/admin/proses/{{ $d->id }}">
                                    <button>Proses</button>
                                </a>
                            @elseif($d->status == 'proses')
                                <a href="/admin/selesai/{{ $d->id }}">
                                    <button>Selesai</button>
                                </a>
                            @else
                                -
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>
</html>