@extends('admin.layouts.app')

@section('title', '管理者バナー管理ページ')

@section('content')
<div class="container-fluid mt-0 overflow-visible px-5">
    <a href="{{ url('/admin/top') }}" 
       class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-300 inline-block text-decoration-none fs-1 mt-0">
       ← 戻る
    </a>

    <div class="font-bold" style="font-size: 50px;">
        バナー管理
    </div>

    <div id="toast-container" style="position: fixed; top: 50px; left: 50%; transform: translateX(-50%); display: none; z-index: 9999;">
    <div id="toast-message" style="color: white; padding: 10px 20px; border-radius: 5px;"></div>
</div>

    {{-- バナー登録フォーム --}}
    <form id="banner-form" enctype="multipart/form-data">
        @csrf
        <div class="d-flex flex-column align-items-start gap-3" style="margin-left: 300px;">
            <table class="w-full" id="banner-rows"></table>

            <button type="button" id="add-row"
                    class="btn btn-success rounded-circle d-flex justify-content-center align-items-center"
                    style="width:36px; height:36px; line-height:1; padding:0;">
                ＋
            </button>
        </div>
    </form>

    <div class="position-fixed bottom-0 start-50 translate-middle-x mb-3">
        <button type="button" id="submit-btn"
                class="btn btn-secondary rounded-0 fs-3 px-8 py-1" style="min-width: 300px;">
            登録
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const bannerRows = document.getElementById('banner-rows');
    const addRowBtn = document.getElementById('add-row');
    const submitBtn = document.getElementById('submit-btn');

    // --- 既存バナー表示 ---
    const existingBanners = @json($banners ?? []);
    existingBanners.forEach(b => bannerRows.appendChild(createBannerRow(b.id, b.image)));

    // --- 新規行追加 ---
    addRowBtn.addEventListener('click', () => bannerRows.appendChild(createBannerRow(null, '')));

    // --- 行削除 ---
    bannerRows.addEventListener('click', (e) => {
        const removeBtn = e.target.closest('.remove-row');
        if(!removeBtn) return;

        const row = removeBtn.closest('tr');
        const bannerId = row.dataset.id;

        if(bannerId){
            if(confirm('本当に削除しますか？')){
                fetch('http://localhost:8888/influencer_education_nogaki-team/public/admin/banner/' + bannerId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if(!res.ok) throw new Error('サーバーエラー: ' + res.status);
                    const contentType = res.headers.get('content-type');
                    if(!contentType || !contentType.includes('application/json')) {
                        throw new Error('JSONを期待したがHTMLが返ってきました');
                    }
                    return res.json();
                })
                .then(data => {
                
                    if(data.success){
                        row.remove();
                        showAlert('削除成功', 'success');
                    } else {
                        showAlert('削除失敗', 'error');
                    }
                })
                .catch(err => showAlert(err.message, 'error'));
            }
        } else {
            row.remove(); // 新規行は画面上だけ削除
        }
    });

    // --- 登録ボタン（Ajax） ---
    submitBtn.addEventListener('click', () => {
    const formData = new FormData();
    let hasFile = false;

    document.querySelectorAll('.file-input').forEach(input => {
        if(input.files[0]) {
            formData.append('banners[]', input.files[0]);
            hasFile = true;
        }
    });

    if(!hasFile){
        showAlert('ファイルが選択されていません', 'error');
        return;
    }

    fetch('{{ url("admin/banner/register") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            showAlert('登録成功', 'success');
            // 行リセット＆再描画
            bannerRows.innerHTML = '';
            data.banners.forEach(b => bannerRows.appendChild(createBannerRow(b.id, b.image)));
        } else {
            if(data.errors){
                showAlert(data.errors.join("\n"), 'error');
            } else {
                showAlert(data.message || '登録失敗', 'error');
            }
        }
    })
    .catch(err => showAlert(err.message, 'error'));
});

    // --- 行作成関数 ---
    // --- 行作成関数 ---
function createBannerRow(id, imageName){
    const uniqueId = 'fileElem-' + Date.now() + Math.floor(Math.random()*1000);
    const row = document.createElement('tr');
    row.dataset.id = id || '';
    row.className = 'align-middle';

    row.innerHTML = `
        <td class="py-2 px-2 d-flex align-items-center gap-2">
            <img src="${imageName ? '{{ asset('storage/images/banner/') }}' + '/' + imageName : ''}" 
                 class="preview rounded object-cover" 
                 alt="preview"
                 style="width:240px; height:160px; object-fit:cover; display:${imageName ? 'block' : 'none'};">
            
            <input type="file" id="${uniqueId}" class="file-input" accept="image/*" style="display:none;" name="banners[]">
            <button type="button" class="file-select-btn bg-white text-black border border-gray-400 px-5 py-2 text-lg rounded-0">
                ファイルを選択
            </button>

            <button type="button" class="btn btn-danger rounded-circle remove-row d-flex justify-content-center align-items-center" style="width:36px; height:36px; line-height:1; padding:0;">－</button>
        </td>
    `;

    const fileInput = row.querySelector('.file-input');
    const fileBtn = row.querySelector('.file-select-btn');
    const preview = row.querySelector('.preview');

    fileBtn.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if(file){
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            fileBtn.textContent = file.name;
        } else {
            preview.src = '';
            preview.style.display = 'none';
            fileBtn.textContent = 'ファイルを選択';
        }
    });

    return row;
}


    // --- アラート表示 ---
    function showAlert(message, type){
    const container = document.getElementById('toast-container');
    const toast = document.getElementById('toast-message');

    toast.textContent = message;

    // ✅ 背景色の切り替え（成功:緑 / エラー:赤）
    toast.style.background = type === 'success' ? '#ffffffff' : '#ffffffff';

    // ✅ サイズ・見た目を変更
    toast.style.fontSize = '20px';        // フォントサイズ大きく
    toast.style.padding = '15px 30px';    // 内側余白を広く
    toast.style.borderRadius = '8px';     // 角を丸く
    toast.style.minWidth = '300px';       // 幅を広げる
    toast.style.textAlign = 'center';     // 中央寄せ
    toast.style.border = '2px solid black';
    toast.style.color = 'black'; 

    container.style.display = 'block';

    setTimeout(() => {
        container.style.display = 'none';
    }, 3000);
}
});
</script>

@endsection
