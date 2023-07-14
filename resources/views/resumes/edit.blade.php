@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Resume</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('resumes.update', $resume->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">
                                Title
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $resume->title }}" required autocomplete="title" autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Name
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $resume->user->name }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email
                            </label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $resume->email }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="website" class="form-label">
                                Website
                            </label>
                            <input type="website" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website') ?? $resume->website }}" autocomplete="website" autofocus>

                            @error('website')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="picture" class="form-label">
                                Picture
                            </label>
                            <input type="file" class="form-control @error('picture') is-invalid @enderror" name="picture">

                            @error('picture')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="about" class="form-label">
                                About
                            </label>
                            <textarea class="form-control @error('about') is-invalid @enderror" name="about">{{ old('about') ?? $resume->about }}</textarea>

                            @error('about')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
