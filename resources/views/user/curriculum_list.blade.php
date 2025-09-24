@extends('user.layouts.app')

@section('title', 'ユーザー時間割ページ')

@section('content')
<style>
#curriculumList ul li span.time {
    margin-left: 10px; /* 日付と時間の間に余白 */
}
.card {
    display: flex;
    justify-content: center; /* 横中央 */
    align-items: center;     /* 縦中央 */
    height: 200px;           /* 高さを固定 */
    padding-top: 10px;       /* 上に余白を追加 */
}
.card img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;     
}
</style>
<div class="container-fluid mt-0 overflow-visible px-5">
    <div class="d-flex align-items-center mb-4">
        <!-- 戻るボタン -->
        <a href="{{ url('/user/top') }}" 
           class="bg-gray-200 text-black px-4 py-3 rounded hover:bg-gray-300 text-decoration-none me-3 fs-3">
           ← 戻る
        </a>

        <!-- 月切り替えリンク -->
        <div class="d-flex align-items-center">
            <a href="#" id="prevMonth" class="me-2 text-decoration-none fs-2 text-black">◀</a>
            <span id="currentMonth" class="fs-2">{{ \Carbon\Carbon::now()->format('Y年n月') }}スケジュール</span>
            <a href="#" id="nextMonth" class="ms-2 text-decoration-none fs-2 text-black">▶</a>

            <!-- 現在選択中の学年表示 -->
            <span id="currentGrade" class="ms-3 btn fs-6 py-1 rounded-pill" 
                  style="width: 130px; background-color: #99ddff; color: black;">
                  小学校1年生
            </span>
        </div>
    </div>

    <div class="row">
        <!-- 左サイドメニュー -->
        <div class="col-2">
            <ul class="nav flex-column gap-2 p-4">
                @for($i = 1; $i <= 12; $i++)
                    @php
                        $color = $i <= 6 ? '#99ddff' : ($i <= 9 ? '#88eecc' : '#a6d96a');
                        $label = $i <= 6 ? "小学校{$i}年生" : ($i <= 9 ? "中学校" . ($i-6) . "年生" : "高校" . ($i-9) . "年生");
                    @endphp
                    <li class="nav-item">
                        <a href="#" data-grade="{{ $i }}" data-color="{{ $color }}" class="btn fs-6 py-1 rounded-pill grade-btn" 
                           style="width: 130px; background-color: {{ $color }}; color: black;">
                            {{ $label }}
                        </a>
                    </li>
                @endfor
            </ul>
        </div>

        <div class="col-md-7">
            <!-- カリキュラム表示 -->
            <div id="curriculumList" class="row row-cols-1 row-cols-md-3 g-4"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentDate = new Date();
    let selectedGrade = 1; 

    const gradeDisplay = document.getElementById('currentGrade');
    const gradeButtons = document.querySelectorAll('.grade-btn');

    // Laravel route() を Blade で JS に渡す
    const monthRoute = "{{ route('user.curriculums.month') }}";

    function formatDateTime(dtStr) {
        const dt = new Date(dtStr);
        const year = dt.getFullYear();
        const month = dt.getMonth() + 1;
        const day = dt.getDate();
        const h = dt.getHours();
        const m = String(dt.getMinutes()).padStart(2, '0');
        return `${year}年${month}月${day}日 ${h}:${m}`;
    }

    function fetchCurriculums(date, grade = 1) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const monthParam = `${year}-${month}`;

        document.getElementById('currentMonth').textContent =
            year + '年' + (date.getMonth() + 1) + '月スケジュール';

        // route() を使った fetch
        fetch(`${monthRoute}?month=${monthParam}&grade=${grade}`)
            .then(res => {
                console.log('HTTPステータス:', res.status);
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                console.log('取得データ:', data);

                let html = '';
                if (!data.length) {
                    html = '<p class="text-center fs-5 mt-4">現在カリキュラムはありません。</p>';
                } else {
data.forEach(curriculum => {
    // デフォルトはリンクなし
    let deliveryLink = '#';

    if (curriculum.delivery_times && curriculum.delivery_times.length > 0) {
        // 常時配信フラグが立っている配信を探す
        const alwaysDelivery = curriculum.delivery_times.find(time => curriculum.alway_delivery_flg == 1);

        if (alwaysDelivery) {
            deliveryLink = `/delivery/${alwaysDelivery.id}`;
        } else {
            // 最初の配信をデフォルトに
            deliveryLink = `/delivery/${curriculum.delivery_times[0].id}`;
        }
    }

    html += `<div class="col">
        <div class="card h-100 shadow-sm rounded-0 bg-white">
            <img src="${curriculum.thumbnail_url}" class="img-fluid">
            <div class="card-body p-2">
                <h5 class="card-title text-left fs-4 px-3">
                    <a href="${deliveryLink}" class="text-decoration-none text-black">
                        ${curriculum.title}
                    </a>
                </h5>
                <ul class="list-unstyled text-left mb-0 fs-4 px-3">
                    ${
                        curriculum.delivery_times && curriculum.delivery_times.length > 0
                        ? curriculum.delivery_times.map(time => {
                            const from = new Date(time.delivery_from);
                            const to = new Date(time.delivery_to);

                            const flagLabel = curriculum.alway_delivery_flg == 1 
                                ? `<span class="ms-2 text-success">&#10003;</span>` 
                                : "";

                            return `<li>
                                <a href="/delivery/${time.id}" class="text-decoration-none text-black">
                                    ${from.getMonth()+1}月${from.getDate()}日 
                                    <span class="time">
                                        ${from.getHours()}:${String(from.getMinutes()).padStart(2,'0')} 
                                        〜 ${to.getHours()}:${String(to.getMinutes()).padStart(2,'0')}
                                    </span>
                                    ${flagLabel}
                                </a>
                            </li>`;
                        }).join('')
                        : '<li>配信予定はありません</li>'
                    }
                </ul>
            </div>
        </div>
    </div>`;
});

                }
                document.getElementById('curriculumList').innerHTML = html;
            })
            .catch(err => console.error('Fetch エラー:', err));
    }

    // 初回表示
    fetchCurriculums(currentDate, selectedGrade);

    // 学年ボタン処理
    gradeButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            selectedGrade = this.dataset.grade;
            gradeDisplay.textContent = this.textContent;
            gradeDisplay.style.backgroundColor = this.dataset.color;
            gradeButtons.forEach(b => b.style.backgroundColor = b.dataset.color);
            this.style.backgroundColor = '#ffaa00';
            fetchCurriculums(currentDate, selectedGrade);
        });
    });

    // 初期状態
    const firstBtn = gradeButtons[0];
    gradeDisplay.textContent = firstBtn.textContent;
    gradeDisplay.style.backgroundColor = firstBtn.dataset.color;
    firstBtn.style.backgroundColor = '#ffaa00';

    // 月切り替え
    document.getElementById('prevMonth').addEventListener('click', function(e){
        e.preventDefault();
        currentDate.setMonth(currentDate.getMonth() - 1);
        fetchCurriculums(currentDate, selectedGrade);
    });
    document.getElementById('nextMonth').addEventListener('click', function(e){
        e.preventDefault();
        currentDate.setMonth(currentDate.getMonth() + 1);
        fetchCurriculums(currentDate, selectedGrade);
    });
});
</script>
@endsection
