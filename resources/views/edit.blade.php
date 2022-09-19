<html>
    <body>
        <form method="POST" action="{{url('mahasiswa/'.$id)}}" enctype="multipart/form-data">
            @csrf
            {!! method_field('PUT') !!}
        Username <input type="text" name="username" required value="{{$data->username}}"><br>
        Nama <input type="text" name="nama" required value="{{$data->nama}}"><br>
        Email <input type="text" name="email" required value="{{$data->email}}"><br>
        Password <input type="text" name="password" required value="{{$data->password}}"><br>
        @if($data->avatar)
            <img src="{{ asset('images/'.$data->avatar) }}" alt="" width="100px"><br>
        @endif

        File <input type="file" name="berkas" required accept=".jpg,.png">
        <button type="submit">Simpan</button>

        @if(isset($error))
            {{ $error }}
        @endif
        </form>    
    </body>
</html>