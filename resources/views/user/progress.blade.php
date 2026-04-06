<php>

<h1>授業進捗</h1>

<div>
    <p>名前: {{ $user->name }}</p>
    <p>学年: {{ optional($user->schoolClass)->name }}</p>
</div>

@foreach ($classes as $class)
    <h2>{{ $class->name }}</h2>

    <ul>
        @foreach ($class->curriculums as $curriculum)
            <li>
                {{ $curriculum->title }}
                @if (in_array($curriculum->id, $clearCurriculumIds))
                    <span>受講済み</span>
                @endif
            </li>
        @endforeach
    </ul>
@endforeach

</php>