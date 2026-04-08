<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengaduan</title>

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
            display: flex;
            justify-content: center;
        }

        form {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        label {
            font-weight: bold;
            color: #333;
        }

        select, textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        textarea {
            resize: none;
            height: 100px;
        }

        select:focus, textarea:focus, input:focus {
            border-color: #2196f3;
            outline: none;
        }

        img {
            margin-top: 10px;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #2196f3;
            color: white;
            border: none;
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
        <h2>Edit Pengaduan</h2>

        <a href="/pengaduan">Kembali</a>
        <a href="/logout">Logout</a>
    </div>

    <div class="container">
        <form method="POST" action="/pengaduan/update/{{ $data->id }}" enctype="multipart/form-data">
            @csrf

            <label>Kategori</label>
            <select name="idkategori" required>
                @foreach($kategori as $k)
                    <option value="{{ $k->idkategori }}"
                        {{ $data->idkategori == $k->idkategori ? 'selected' : '' }}>
                        {{ $k->ketkategori }}
                    </option>
                @endforeach
            </select>

            <label>Isi Laporan</label>
            <textarea name="isi_laporan" required>{{ $data->isi_laporan }}</textarea>

            @if($data->foto)
                <img src="{{ asset('img/'.$data->foto) }}" width="120">
            @else
            
                <p>Tidak ada foto</p>
            @endif

            <label>Ganti Foto</label>
            <input type="file" name="foto" accept="image/*">

            <button type="submit">Update Pengaduan</button>
        </form>
    </div>

</body>
</html>