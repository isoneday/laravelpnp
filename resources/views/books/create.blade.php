<form action="{{ route('books.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Judul Buku">
    <input type="text" name="author" placeholder="Penulis">
    <input type="number" name="stock" placeholder="Stok">
    <input type="number" step="0.01" name="price" placeholder="Harga">
  <input type="text" name="published_by" required placeholder="Nama Penerbit">

    <button type="submit">Terbitkan Buku</button>
</form>
