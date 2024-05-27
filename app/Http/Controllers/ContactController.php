<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = auth()->user()->contacts()->paginate(10);

        return view('contacts', compact('contacts'));
    }

    public function search(Request $request)
    {
      $keyword = $request->input('keyword');
      $contacts = $request->user()->contacts()
          ->where('name', 'like', "%$keyword%")
          ->orWhere('email', 'like', "%$keyword%")
          ->orWhere('phone', 'like', "%$keyword%")
          ->paginate(10);
      return view('contacts', compact('contacts'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete;
        return redirect()->route('contacts')->with('success', 'Contact deleted successfully');
    }
}
