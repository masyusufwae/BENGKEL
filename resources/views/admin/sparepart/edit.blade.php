<h2>Edit Sparepart</h2>

<form action="{{ route('sparepart.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nama_part" value="{{ $data->nama_part }}">
    <input type="text" name="stok" value="{{ $data->stok }}">
    <input type="text" name="harga_jual" value="{{ $data->harga_jual }}">

    <button type="submit">Update</button>
</form>
