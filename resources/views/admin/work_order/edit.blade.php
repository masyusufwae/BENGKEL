<h2>Edit Work Order</h2>

<form action="{{ route('work-order.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nomor_wo" value="{{ $data->nomor_wo }}">
    <input type="text" name="keluhan" value="{{ $data->keluhan }}">
    <input type="text" name="status" value="{{ $data->status }}">

    <button type="submit">Update</button>
</form>
