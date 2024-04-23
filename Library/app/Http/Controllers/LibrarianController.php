<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;


class LibrarianController extends Controller
{

    public function store(Request $request)                           //добавить книгу в бд
    {
        $validated = $request->validate([
            'title' => 'string',
            'author' => 'string',
            'genre' => 'string',
            'shortDescription' => 'string',
            'description' => 'string',
            'picture' => 'string',
        ]);
        Book::create($validated);
        return('записано');
    }

    public function issueBook($code)
    {
        $booking = Booking::where('code', $code)->first();
        $book = Book::where('id', $booking['idBook'])->first();
        $user = User::where('id', $booking['idUser'])->first();
        $result = [$book['title'], $user['name'], $booking['id']];
        return $result;
    }

    public function changeStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();
    }

    public function getUserBook($title)
    {
        $book = Book::where('title', $title)->first();
        $booking = Booking::where('idBook', $book['id'])->first();
        $booking->delete();
        return('deleted');
    }

    public function deleteBook($id)
    {
        $book =  Book::where('id', $id)->first();
        $book->delete();
        return('deleted');
    }
    public function booking(Request $request)                     //добавить запись о бронировании
    {
        $validated = $request->validate([
            'idBook' => 'integer',
            'idUser' => 'integer',
            'code' => 'integer',
            'status' => 'string',
        ]);
        $booking = Booking::create($validated);
        return(response()->json(['id' => $booking->id]));
    }

    public function deleteBooking(Request $request)
    {
        $request->validate(['idBook' => 'integer']);
        $booking = Booking::where('idBook', $request['idBook'])->first();
        $booking->delete();
        return('удаленно');

    }
    public function getBooking($idUser)
    {
        $data = Booking::where('idUser', $idUser)->first();
        $titleBook = Book::where('id', $data['idBook'])->first();

        $allData = [$titleBook['title'], $data['code']];
        return $allData;
    }

    public function getBookingBook()
    {
        $booking = Booking::all();
        return $booking;
    }

}

