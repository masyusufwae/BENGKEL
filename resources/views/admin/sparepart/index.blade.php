<h2>Data Sparepart</h2>

<a href="{{ route('sparepart.create') }}">Tambah</a>

@foreach($data as $d)
    <p>
        {{ $d->nama_part }} - Stok: {{ $d->stok }} - Harga: Rp {{ $d->harga_jual }}

        <a href="{{ route('sparepart.edit', $d->id) }}">Edit</a>

        <form action="{{ route('sparepart.destroy', $d->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </p>
@endforeach
