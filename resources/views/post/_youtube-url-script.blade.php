<script>
(function(){
    const wrapper = document.getElementById('youtube-urls-wrapper');
    const addBtn  = document.getElementById('add-url');
    if (!wrapper || !addBtn) return;

    const inputClass = 'flex-1 px-4 py-3 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition-all duration-200';

    function createRow(value) {
        const row = document.createElement('div');
        row.className = 'youtube-url-row flex items-center gap-2';

        row.innerHTML = `
            <div class="flex flex-col gap-0.5">
                <button type="button" onclick="moveUrl(this, -1)" title="上へ"
                        class="p-0.5 text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors disabled:opacity-30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
                <button type="button" onclick="moveUrl(this, 1)" title="下へ"
                        class="p-0.5 text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors disabled:opacity-30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>
            <input type="text" name="youtube_urls[]"
                   placeholder="https://www.youtube.com/watch?v=…"
                   class="${inputClass}"
                   value="${value || ''}">
            <button type="button" onclick="removeUrl(this)" title="削除"
                    class="p-2 text-neutral-400 hover:text-red-500 transition-colors rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        `;

        return row;
    }

    // 追加ボタン
    addBtn.addEventListener('click', function(){
        wrapper.appendChild(createRow(''));
        updateArrowStates();
    });

    // 上下ボタンの有効/無効を更新
    function updateArrowStates() {
        const rows = wrapper.querySelectorAll('.youtube-url-row');
        rows.forEach(function(row, i) {
            const buttons = row.querySelectorAll(':scope > div > button');
            // 上ボタン: 先頭なら無効
            buttons[0].disabled = (i === 0);
            // 下ボタン: 末尾なら無効
            buttons[1].disabled = (i === rows.length - 1);
        });
    }

    // 削除
    window.removeUrl = function(btn) {
        const row = btn.closest('.youtube-url-row');
        const rows = wrapper.querySelectorAll('.youtube-url-row');

        // 最後の1行の場合は入力値をクリアするだけ
        if (rows.length <= 1) {
            row.querySelector('input').value = '';
            return;
        }

        row.remove();
        updateArrowStates();
    };

    // 並べ替え (direction: -1=上, 1=下)
    window.moveUrl = function(btn, direction) {
        const row = btn.closest('.youtube-url-row');
        const rows = Array.from(wrapper.querySelectorAll('.youtube-url-row'));
        const index = rows.indexOf(row);
        const targetIndex = index + direction;

        if (targetIndex < 0 || targetIndex >= rows.length) return;

        if (direction === -1) {
            wrapper.insertBefore(row, rows[targetIndex]);
        } else {
            wrapper.insertBefore(rows[targetIndex], row);
        }

        updateArrowStates();
    };

    // 初期化
    updateArrowStates();
})();
</script>
