<h2>Tambah Work Order</h2>

<form action="{{ route('work-order.store') }}" method="POST">
    @csrf
    <input type="text" name="nomor_wo" placeholder="Nomor WO">
    <input type="text" name="keluhan" placeholder="Keluhan">
    <input type="text" name="status" placeholder="Status">
    <button type="submit">Simpan</button>
</form>
