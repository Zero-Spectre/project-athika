@extends('layouts.instruktur.app')

@section('title', 'Create Module')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Create Module for "{{ $kursus->judul }}"</h1>
            <a href="{{ route('instruktur.courses.show', $kursus) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Course
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Module Information</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('instruktur.modules.store', $kursus) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Module Title</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tipe_materi" class="form-label">Material Type</label>
                        <select class="form-select" id="tipe_materi" name="tipe_materi" required>
                            <option value="">Select a type</option>
                            <option value="Video" {{ old('tipe_materi') == 'Video' ? 'selected' : '' }}>Video</option>
                            <option value="Artikel" {{ old('tipe_materi') == 'Artikel' ? 'selected' : '' }}>Article</option>
                            <option value="Kuis" {{ old('tipe_materi') == 'Kuis' ? 'selected' : '' }}>Quiz</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="urutan" class="form-label">Order</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="{{ old('urutan', $kursus->moduls->count() + 1) }}" min="1" required>
                        <div class="form-text">The order in which this module appears in the course.</div>
                    </div>
                    
                    <div class="mb-3" id="quiz_field" style="display: none;">
                        <label for="quiz_id" class="form-label">Associated Quiz</label>
                        <select class="form-select" id="quiz_id" name="quiz_id">
                            <option value="">Select a quiz (optional)</option>
                            @foreach($quizzes as $quiz)
                                <option value="{{ $quiz->id }}" {{ old('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                    {{ Str::limit($quiz->question, 50) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Link this module to an existing quiz for assessment.</div>
                    </div>
                    
                    <div class="mb-3" id="konten_teks_field" style="display: none;">
                        <label for="konten_teks" class="form-label">Article Content</label>
                        <input id="konten_teks" type="hidden" name="konten_teks" value="{{ old('konten_teks') }}">
                        <trix-editor input="konten_teks"></trix-editor>
                    </div>
                    
                    <div class="mb-3" id="penjelasan_field" style="display: none;">
                        <label for="penjelasan" class="form-label">Detailed Explanation</label>
                        <textarea class="form-control" id="penjelasan" name="penjelasan" rows="5">{{ old('penjelasan') }}</textarea>
                        <div class="form-text">Provide a detailed explanation to help students understand the material.</div>
                    </div>
                    
                    <div class="mb-3" id="video_fields" style="display: none;">
                        <label class="form-label">Video Content</label>
                        
                        <!-- Video Type Selection -->
                        <div class="mb-3">
                            <label class="form-label">Video Source</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="video_type" id="video_type_upload" value="upload" checked>
                                <label class="form-check-label" for="video_type_upload">
                                    Upload Video
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="video_type" id="video_type_link" value="link">
                                <label class="form-check-label" for="video_type_link">
                                    YouTube Link
                                </label>
                            </div>
                        </div>
                        
                        <!-- Upload Video Fields -->
                        <div id="upload_video_fields">
                            <div class="mb-3">
                                <label for="video_file" class="form-label">Upload Video</label>
                                <input type="file" class="form-control" id="video_file" name="video_file" accept="video/*">
                                <div class="form-text">Upload a video file (MP4, MOV, AVI). Maximum size: 1GB.</div>
                            </div>
                        </div>
                        
                        <!-- YouTube Link Fields -->
                        <div id="link_video_fields" style="display: none;">
                            <div class="mb-3">
                                <label for="url_video" class="form-label">YouTube Video URL</label>
                                <input type="url" class="form-control" id="url_video" name="url_video" value="{{ old('url_video') }}" placeholder="https://www.youtube.com/watch?v=...">
                                <div class="form-text">Enter the YouTube video URL.</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="video_thumbnail" class="form-label">Video Thumbnail</label>
                            <input type="file" class="form-control" id="video_thumbnail" name="video_thumbnail" accept="image/*">
                            <div class="form-text">Upload a thumbnail image for the video (optional). JPG, PNG, GIF up to 2MB.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="video_deskripsi" class="form-label">Video Description</label>
                            <textarea class="form-control" id="video_deskripsi" name="video_deskripsi" rows="3">{{ old('video_deskripsi') }}</textarea>
                            <div class="form-text">Brief description of the video content.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="durasi_video" class="form-label">Video Duration (seconds)</label>
                            <input type="number" class="form-control" id="durasi_video" name="durasi_video" value="{{ old('durasi_video') }}" min="0">
                            <div class="form-text">Duration of the video in seconds.</div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('instruktur.courses.show', $kursus) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Module</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include Trix CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipeMateri = document.getElementById('tipe_materi');
    const quizField = document.getElementById('quiz_field');
    const kontenTeksField = document.getElementById('konten_teks_field');
    const penjelasanField = document.getElementById('penjelasan_field');
    const videoFields = document.getElementById('video_fields');
    
    // Video type selection
    const videoTypeUpload = document.getElementById('video_type_upload');
    const videoTypeLink = document.getElementById('video_type_link');
    const uploadVideoFields = document.getElementById('upload_video_fields');
    const linkVideoFields = document.getElementById('link_video_fields');
    
    // Video type change handler
    function handleVideoTypeChange() {
        if (videoTypeUpload.checked) {
            uploadVideoFields.style.display = 'block';
            linkVideoFields.style.display = 'none';
        } else {
            uploadVideoFields.style.display = 'none';
            linkVideoFields.style.display = 'block';
        }
    }
    
    videoTypeUpload.addEventListener('change', handleVideoTypeChange);
    videoTypeLink.addEventListener('change', handleVideoTypeChange);
    
    tipeMateri.addEventListener('change', function() {
        // Hide all fields first
        quizField.style.display = 'none';
        kontenTeksField.style.display = 'none';
        penjelasanField.style.display = 'none';
        videoFields.style.display = 'none';
        
        // Show fields based on material type
        if (this.value === 'Kuis') {
            quizField.style.display = 'block';
        } else if (this.value === 'Artikel') {
            kontenTeksField.style.display = 'block';
            penjelasanField.style.display = 'block';
        } else if (this.value === 'Video') {
            videoFields.style.display = 'block';
            penjelasanField.style.display = 'block';
        }
    });
    
    // Trigger change event on page load to show the correct fields
    if (tipeMateri.value) {
        tipeMateri.dispatchEvent(new Event('change'));
    }
    
    // Handle video file size validation
    const videoFileInput = document.getElementById('video_file');
    if (videoFileInput) {
        videoFileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSizeMB = file.size / (1024 * 1024);
                if (fileSizeMB > 1024) { // 1GB limit
                    alert('File size exceeds 1GB limit. Please choose a smaller file.');
                    this.value = '';
                }
            }
        });
    }
});
</script>
@endsection