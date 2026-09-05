<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);
        $unreadCount = ContactMessage::where('is_read', false)->count();
        return view('backoffice.contact_messages.index', compact('messages', 'unreadCount'));
    }

    public function show(ContactMessage $contact_message)
    {
        if (!$contact_message->is_read) {
            $contact_message->update(['is_read' => true]);
        }
        return view('backoffice.contact_messages.show', compact('contact_message'));
    }

    public function toggleRead(ContactMessage $contact_message)
    {
        $contact_message->update(['is_read' => !$contact_message->is_read]);
        return redirect()->back()->with('success', 'Message status updated.');
    }

    public function destroy(ContactMessage $contact_message)
    {
        $contact_message->delete();
        return redirect()->route('contact-messages.index')->with('success', 'Inquiry deleted successfully.');
    }
}
