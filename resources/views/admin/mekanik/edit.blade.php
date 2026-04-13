<h2>Edit Mekanik</h2>

<form action="{{ route('mekanik.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nama_mekanik" value="{{ $data->nama_mekanik }}">
    <input type="text" name="nip" value="{{ $data->nip }}">
    <input type="text" name="spesialisasi" value="{{ $data->spesialisasi }}">
    <input type="text" name="status" value="{{ $data->status }}">

    <button type="submit">Update</button>
</form>
