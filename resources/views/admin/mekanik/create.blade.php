<h2>Tambah Mekanik</h2>

<form action="{{ route('mekanik.store') }}" method="POST">
    @csrf
    <input type="text" name="nama_mekanik" placeholder="Nama">
    <input type="text" name="nip" placeholder="NIP">
    <input type="text" name="spesialisasi" placeholder="Spesialisasi">
    <input type="text" name="status" placeholder="Status">
    <button type="submit">Simpan</button>
</form>