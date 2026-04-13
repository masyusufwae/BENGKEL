<h2>Tambah Jenis Servis</h2>

<form action="{{ route('jenis-servis.store') }}" method="POST">
    @csrf
    <input type="text" name="nama_servis" placeholder="Nama Servis">
    <input type="text" name="harga_jasa" placeholder="Harga Jasa">
    <input type="text" name="estimasi_waktu" placeholder="Estimasi Waktu">
    <button type="submit">Simpan</button>
</form>
