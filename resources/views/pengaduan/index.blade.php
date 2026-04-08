<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaduan Sarana</title>

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

        img {
            border-radius: 5px;
        }

        a {
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-edit {
            color: #2196f3;
        }

        .btn-delete {
            color: red;
        }

    </style>

</head>
<body>

    <div class="navbar">
        <h2>Pengaduan Sarana</h2>
        <a href="/pengaduan/add">Buat Pengaduan</a>
        <a href="/logout">Logout</a>
    </div>

    <div class="container">

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Isi Laporan</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Aksi</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($d->tg_pengaduan)) }}</td>

                        <td>{{ \Illuminate\Support\Str::limit($d->isi_laporan, 80) }}</td>

                        <td>
                            @if($d->foto)
                                <img src="{{ asset('img/'.$d->foto) }}" width="80">
                            @else
                                Tidak ada
                            @endif
                        </td>

                        <td>
                            @if($d->status == '0')
                                Menunggu
                            @elseif($d->status == 'proses')
                                Diproses
                            @elseif($d->status == 'selesai')
                                Selesai
                            @endif
                        </td>

                        <td>
                            <a href="/pengaduan/edit/{{ $d->id }}" class="btn-edit">Edit</a> |
                            <a href="/pengaduan/delete/{{ $d->id }}" 
                               class="btn-delete"
                               onclick="return confirm('Yakin mau hapus?')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>
</html>