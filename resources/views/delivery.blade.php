@extends('layouts.app')

@section('content')
    <div class="container">
        <p>
            <a class="history" href="javascript:history.back()">←戻る</a>
        </p>
        <div class="videoArea">
            <p>
            @if($canView)
                <video class="video" src="{{ $curriculum->video_url }}" controls></video>
            @else
                <img class="video" src="{{ $curriculum->thumbnail }}" alt="配信期間外">
            @endif
            </p>
            <p>
            @if($canView)
            <form action="{{ route('curriculum_progress_regist') }}" method="post" enctype="multipart/form-data">
             @csrf
                <input type="hidden" name="curriculums_id" value={{ $curriculum->id}}>
                <input type="hidden" name="users_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="clear_flg" value="1">
                <button type="submit" class="curClear">受講しました</button>
            </form>
            @endif
            </p>
        </div>
        <p class="gradename">{{ $grade->name }}</p>
        <p class="curTitle">{{ $curriculum->title }}</p>
        {{-- <p >《講座内容》</p> --}}
        <p class="curDescription">{{ $curriculum->description }}</p>

    </div>
@endsection
