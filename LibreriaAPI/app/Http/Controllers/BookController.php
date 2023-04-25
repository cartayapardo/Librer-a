<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Book;

class BookController extends BaseController
{
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }

    public function actives(Request $request)
    {
        $books = Book::where('active', 1)->where('user_id', null)->get();
        return ['success' => true, 'data' => $books, 'sms' => 'Datos cargados correctamente'];
    }

    public function booksreserved(Request $request)
    {
        $books = Book::where('user_id', '!=', null)->get();
        return ['success' => true, 'data' => $books, 'sms' => 'Datos cargados correctamente'];
    }

    public function booksreservedXClient(Request $request)
    {
        $user = $request->user();
        $books = Book::where('user_id', $user->id)->get();
        return ['success' => true, 'data' => $books, 'sms' => 'Datos cargados correctamente'];
    }

    public function booksXClient(Request $request)
    {
        $payload = $request->all();
        $books = Book::where('user_id', $payload['id'])->get();
        return ['success' => true, 'data' => $books, 'sms' => 'Datos cargados correctamente'];
    }

    public function reserveBook(Request $request)
    {
        $payload = $request->all();
        $user = $request->user();
        $book = $this->find($payload['book_id']);
        if (!$book){
            return ['success' => false, 'data' => null, 'sms' => 'No existe el libro'];
        }
        $currentDate = Carbon::now();
        $endDate = $currentDate->addDay(2);
        $book->reservation_date = $currentDate;
        $book->deadline = $endDate;
        $book->user_id = $user->id;
        $book->save();
        return ['success' => true, 'data' => $book, 'sms' => 'Reserva realizada con éxito'];
    }

    public function returnBook(Request $request)
    {
        $payload = $request->all();
        $book = $this->find($payload['book_id']);
        if (!$book){
            return ['success' => false, 'data' => null, 'sms' => 'No existe el libro'];
        }
        $book->reservation_date = null;
        $book->deadline = null;
        $book->user_id = null;
        $book->save();
        return ['success' => true, 'data' => $book, 'sms' => 'Devolución realizada con éxito'];
    }
}
