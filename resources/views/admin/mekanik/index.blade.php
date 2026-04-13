<h2>Data Mekanik</h2>

<a href="{{ route('mekanik.create') }}">Tambah</a>

@foreach($data as $d)
    <p>
        {{ $d->nama_mekanik }} - {{ $d->spesialisasi }}

        <a href="{{ route('mekanik.edit', $d->id) }}">Edit</a>

        <form action="{{ route('mekanik.destroy', $d->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </p>
@endforeach