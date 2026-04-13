<h2>Data Jenis Servis</h2>

<a href="{{ route('jenis-servis.create') }}">Tambah</a>

@foreach($data as $d)
    <p>
        {{ $d->nama_servis }} - Rp {{ $d->harga_jasa }} ({{ $d->estimasi_waktu }})

        <a href="{{ route('jenis-servis.edit', $d->id) }}">Edit</a>

        <form action="{{ route('jenis-servis.destroy', $d->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </p>
@endforeach
