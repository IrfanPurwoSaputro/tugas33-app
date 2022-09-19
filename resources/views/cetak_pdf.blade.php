<html>
    <head>
        <style>
            table{
                width: 100%;
                border: 1px solid black;
            }
            th, td{
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <h2>Laporan Data Mahasiswa</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Avatar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $d)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $d->username }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->email }}</td>
                    <td><img width="150px" src="{{ url('/images/'.$d->avatar) }}" alt=""></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>