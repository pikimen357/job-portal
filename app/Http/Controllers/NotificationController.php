<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Tampilkan semua notifikasi
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    // Tandai sebagai dibaca
    public function markAsRead($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        // Redirect ke URL yang sesuai
        if (isset($notification->data['application_id'])) {
            return redirect()->route('applications.index')
                ->with('success', 'Notifikasi ditandai sebagai dibaca');
        }

        return back()->with('success', 'Notifikasi ditandai sebagai dibaca');
    }

    // Tandai semua sebagai dibaca
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi ditandai sebagai dibaca');
    }

    // Hapus notifikasi
    public function destroy($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notification->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus');
    }

    // Hapus semua notifikasi
    public function destroyAll()
    {
        auth()->user()->notifications()->delete();

        return back()->with('success', 'Semua notifikasi berhasil dihapus');
    }

    // Get unread count (untuk API/AJAX)
    public function unreadCount()
    {
        return response()->json([
            'count' => auth()->user()->unreadNotifications->count()
        ]);
    }
}
