<h2>Tambah Sparepart</h2>

<form action="{{ route('sparepart.store') }}" method="POST">
    @csrf
    <input type="text" name="nama_part" placeholder="Nama Part">
    <input type="text" name="stok" placeholder="Stok">
    <input type="text" name="harga_jual" placeholder="Harga Jual">
    <button type="submit">Simpan</button>
</form>
