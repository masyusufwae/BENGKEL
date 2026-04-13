<h1>Dashboard Admin</h1>
<p>Total Work Order: {{ $totalWO }}</p>

<a href="/admin/mekanik">Mekanik</a>
<a href="/admin/jenis-servis">Jenis Servis</a>
<a href="/admin/sparepart">Sparepart</a>
<a href="/admin/work-order">Work Order</a>


// resources/views/admin/mekanik/index.blade.php

<h2>Data Mekanik</h2>
<a href="/admin/mekanik/create">Tambah</a>

@foreach($data as $d)
    <p>{{ $d->nama_mekanik }} - {{ $d->spesialisasi }}</p>
@endforeach
