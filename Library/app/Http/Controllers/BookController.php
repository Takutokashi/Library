<?php
namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Booking;
use Illuminate\Http\Request;


class BookController extends Controller
{
    public function getBooks()                                              //возвращает все книги
    {
        $books = Book::all();
        return $books;
    }
    public function getCategories()                                         //возвращает все категории с проверкой на повторение
    {
        $categories = Book::select('genre')->distinct()->get();
        return $categories;
    }

    public function show($genre)                                       //возвращает книги по выбранной категории
    {
        $books = Book::where('genre' , $genre)->get();
        return $books;
    }

    public function booking(Request $request, Book $book, $id)
    {
        $validated = $request->validate([
            'booking' => 'boolean',
        ]);

        $data = [
            'booking' => $validated['booking'],
        ];
        Book::where('id',$id)->update($validated);
        return('Забронировано в бд книг');
    }
    public function getBookUser($id)
    {
        $data = Book::where('id', $id)->get();
        return $data;
    }
    public function bookUserId($id)
    {
        $booking = Booking::where('idBook', $id)->first();
        return $booking['idUser'];
    }

    public function getAuthors()
    {
        $books = Book::select('author')->distinct()->get();
        return $books;
    }
    public function getAuthor($author)
    {
        $authors = Book::where('author', $author)->get();
        return $authors;
    }
}
