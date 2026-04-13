<h2>Data Work Order</h2>

<a href="{{ route('work-order.create') }}">Tambah</a>

@foreach($data as $d)
    <p>
        {{ $d->nomor_wo }} - {{ $d->keluhan }} - Status: {{ $d->status }}

        <a href="{{ route('work-order.edit', $d->id) }}">Edit</a>

        <form action="{{ route('work-order.destroy', $d->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </p>
@endforeach
