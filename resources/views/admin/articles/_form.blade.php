@csrf

@if ($method === 'PUT')
    @method('PUT')
@endif

<div class="portal-form-row">
    <label for="posted_date">投稿日時</label>
    <input
        id="posted_date"
        name="posted_date"
        type="date"
        value="{{ old('posted_date', optional($article->posted_date)->format('Y-m-d') ?? $article->posted_date) }}"
        class="portal-input @error('posted_date') is-invalid @enderror"
    >
    @error('posted_date')
        <div class="portal-error">{{ $message }}</div>
    @enderror
</div>

<div class="portal-form-row">
    <label for="title">タイトル</label>
    <input
        id="title"
        name="title"
        type="text"
        value="{{ old('title', $article->title) }}"
        class="portal-input @error('title') is-invalid @enderror"
    >
    @error('title')
        <div class="portal-error">{{ $message }}</div>
    @enderror
</div>

<div class="portal-form-row">
    <label for="article_contents">本文</label>
    <textarea
        id="article_contents"
        name="article_contents"
        rows="7"
        class="portal-input portal-textarea @error('article_contents') is-invalid @enderror"
    >{{ old('article_contents', $article->article_contents) }}</textarea>
    @error('article_contents')
        <div class="portal-error">{{ $message }}</div>
    @enderror
</div>

<div class="portal-submit-wrap">
    <button type="submit" class="portal-submit-button">登録</button>
</div>
