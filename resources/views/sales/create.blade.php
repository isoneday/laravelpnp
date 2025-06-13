<form action="{{ route('sales.store') }}" method="POST">
    @csrf
    <select name="book_id">
        @foreach($books as $book)
            <option value="{{ $book->id }}">{{ $book->title }}</option>
        @endforeach
    </select>
    <input type="number" name="quantity" placeholder="Jumlah">
    <input type="text" name="sold_to" placeholder="Pembeli">
    <button type="submit">Beli</button>
</form>
