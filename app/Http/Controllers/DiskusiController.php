<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\DiskusiTopik;
use App\Models\DiskusiKomentar;
use App\Models\DiskusiLike;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DiskusiController extends Controller
{
    /**
     * Display a listing of discussion topics.
     */
    public function index(Request $request)
    {
        $query = DiskusiTopik::with(['user', 'kategori']);
        
        // Filter by category if provided
        if ($request->has('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }
        
        // Filter by search term if provided
        if ($request->has('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        
        // Filter by resolved status if provided
        if ($request->has('resolved')) {
            $query->where('is_resolved', $request->resolved == 'true');
        }
        
        // Order by latest first
        $diskusiTopiks = $query->orderBy('created_at', 'desc')->paginate(10);
        $kategoris = Kategori::all();
        
        return view('diskusi.index', compact('diskusiTopiks', 'kategoris'));
    }

    /**
     * Show the form for creating a new discussion topic.
     */
    public function create(Request $request)
    {
        $kategoris = Kategori::all();
        $modul = null;
        
        // If a module ID is provided, fetch the module
        if ($request->has('modul_id')) {
            $modul = \App\Models\Modul::find($request->modul_id);
        }
        
        return view('diskusi.create', compact('kategoris', 'modul'));
    }

    /**
     * Store a newly created discussion topic in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategori,id',
            'modul_id' => 'nullable|exists:modul,id',
            'konten' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $diskusiTopik = DiskusiTopik::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'modul_id' => $request->modul_id,
            'konten' => $request->konten,
        ]);

        return redirect()->route('diskusi.index')
            ->with('success', 'Discussion topic created successfully.');
    }

    /**
     * Display the specified discussion topic.
     */
    public function show(DiskusiTopik $diskusiTopik)
    {
        // Load the topic with its comments and user information
        $diskusiTopik->load(['user', 'kategori', 'komentars.user']);
        
        // Get comments
        $komentars = $diskusiTopik->komentars()->with(['user'])->get();
        
        return view('diskusi.show', compact('diskusiTopik', 'komentars'));
    }

    /**
     * Show the form for editing the specified discussion topic.
     */
    public function edit(DiskusiTopik $diskusiTopik)
    {
        // Check if the authenticated user is the owner of the topic
        if ($diskusiTopik->user_id !== Auth::id()) {
            return redirect()->route('diskusi.index')
                ->with('error', 'You are not authorized to edit this topic.');
        }
        
        $kategoris = Kategori::all();
        return view('diskusi.edit', compact('diskusiTopik', 'kategoris'));
    }

    /**
     * Update the specified discussion topic in storage.
     */
    public function update(Request $request, DiskusiTopik $diskusiTopik)
    {
        // Check if the authenticated user is the owner of the topic
        if ($diskusiTopik->user_id !== Auth::id()) {
            return redirect()->route('diskusi.index')
                ->with('error', 'You are not authorized to edit this topic.');
        }
        
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategori,id',
            'konten' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $diskusiTopik->update([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'konten' => $request->konten,
        ]);

        return redirect()->route('diskusi.show', $diskusiTopik->id)
            ->with('success', 'Discussion topic updated successfully.');
    }

    /**
     * Remove the specified discussion topic from storage.
     */
    public function destroy(DiskusiTopik $diskusiTopik)
    {
        // Check if the authenticated user is the owner of the topic
        if ($diskusiTopik->user_id !== Auth::id()) {
            return redirect()->route('diskusi.index')
                ->with('error', 'You are not authorized to delete this topic.');
        }
        
        $diskusiTopik->delete();

        return redirect()->route('diskusi.index')
            ->with('success', 'Discussion topic deleted successfully.');
    }

    /**
     * Show the form for editing the specified discussion comment.
     */
    public function editComment(DiskusiKomentar $diskusiKomentar)
    {
        // Check if the authenticated user is the owner of the comment
        if ($diskusiKomentar->user_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'You are not authorized to edit this comment.');
        }
        
        return view('diskusi.edit_comment', compact('diskusiKomentar'));
    }

    /**
     * Update the specified discussion comment in storage.
     */
    public function updateComment(Request $request, DiskusiKomentar $diskusiKomentar)
    {
        // Check if the authenticated user is the owner of the comment
        if ($diskusiKomentar->user_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'You are not authorized to edit this comment.');
        }
        
        $validator = Validator::make($request->all(), [
            'konten' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $diskusiKomentar->update([
            'konten' => $request->konten,
        ]);

        return redirect()->back()
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified discussion comment from storage.
     */
    public function destroyComment(DiskusiKomentar $diskusiKomentar)
    {
        // Check if the authenticated user is the owner of the comment
        if ($diskusiKomentar->user_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'You are not authorized to delete this comment.');
        }
        
        // Decrement the comment count on the topic
        $diskusiKomentar->diskusiTopik->decrement('jumlah_komentar');
        
        $diskusiKomentar->delete();

        return redirect()->back()
            ->with('success', 'Comment deleted successfully.');
    }

    /**
     * Add a comment to a discussion topic.
     */
    public function addComment(Request $request, DiskusiTopik $diskusiTopik)
    {
        $validator = Validator::make($request->all(), [
            'konten' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $komentar = DiskusiKomentar::create([
            'user_id' => Auth::id(),
            'diskusi_topik_id' => $diskusiTopik->id,
            'konten' => $request->konten,
        ]);
        
        // Increment the comment count on the topic
        $diskusiTopik->increment('jumlah_komentar');

        return redirect()->back()
            ->with('success', 'Comment added successfully.');
    }

    /**
     * Mark a discussion topic as resolved.
     */
    public function markAsResolved(DiskusiTopik $diskusiTopik)
    {
        // Check if the authenticated user is the owner of the topic
        if ($diskusiTopik->user_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'You are not authorized to mark this topic as resolved.');
        }
        
        $diskusiTopik->update(['is_resolved' => true]);

        return redirect()->back()
            ->with('success', 'Topic marked as resolved.');
    }

    /**
     * Like a discussion topic.
     */
    public function likeTopic(DiskusiTopik $diskusiTopik)
    {
        // Check if the user has already liked this topic
        $existingLike = DiskusiLike::where('user_id', Auth::id())
            ->where('diskusi_topik_id', $diskusiTopik->id)
            ->first();
            
        if ($existingLike) {
            // Unlike the topic
            $existingLike->delete();
            $diskusiTopik->decrement('jumlah_like');
            $liked = false;
        } else {
            // Like the topic
            DiskusiLike::create([
                'user_id' => Auth::id(),
                'diskusi_topik_id' => $diskusiTopik->id,
            ]);
            $diskusiTopik->increment('jumlah_like');
            $liked = true;
        }
        
        // Return JSON response for AJAX requests
        if (request()->wantsJson()) {
            return response()->json([
                'liked' => $liked,
                'like_count' => $diskusiTopik->jumlah_like,
            ]);
        }
        
        return redirect()->back();
    }

    /**
     * Like a discussion comment.
     */
    public function likeComment(DiskusiKomentar $diskusiKomentar)
    {
        // Check if the user has already liked this comment
        $existingLike = DiskusiLike::where('user_id', Auth::id())
            ->where('diskusi_komentar_id', $diskusiKomentar->id)
            ->first();
            
        if ($existingLike) {
            // Unlike the comment
            $existingLike->delete();
            $diskusiKomentar->decrement('jumlah_like');
            $liked = false;
        } else {
            // Like the comment
            DiskusiLike::create([
                'user_id' => Auth::id(),
                'diskusi_komentar_id' => $diskusiKomentar->id,
            ]);
            $diskusiKomentar->increment('jumlah_like');
            $liked = true;
        }
        
        // Return JSON response for AJAX requests
        if (request()->wantsJson()) {
            return response()->json([
                'liked' => $liked,
                'like_count' => $diskusiKomentar->jumlah_like,
            ]);
        }
        
        return redirect()->back();
    }
}