<h2>Edit Jenis Servis</h2>

<form action="{{ route('jenis-servis.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nama_servis" value="{{ $data->nama_servis }}">
    <input type="text" name="harga_jasa" value="{{ $data->harga_jasa }}">
    <input type="text" name="estimasi_waktu" value="{{ $data->estimasi_waktu }}">

    <button type="submit">Update</button>
</form>
