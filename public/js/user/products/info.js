document.addEventListener('DOMContentLoaded', function () {
    let currentIndex = 0;
    const images = document.querySelectorAll('img[data-index]');
    const thumbnails = document.querySelectorAll('.thumbnail');
    const totalImages = images.length;

    function updateDisplay(newIndex) {
        images[currentIndex].classList.add('hidden');
        thumbnails[currentIndex].classList.remove('border-blue-500');
        thumbnails[currentIndex].classList.add('border-gray-300');

        currentIndex = (newIndex + totalImages) % totalImages;

        images[currentIndex].classList.remove('hidden');
        thumbnails[currentIndex].classList.remove('border-gray-300');
        thumbnails[currentIndex].classList.add('border-blue-500');
    }

    function changeImage(direction) {
        let newIndex = (currentIndex + direction + totalImages) % totalImages;
        updateDisplay(newIndex);
    }

    // 為縮略圖添加點擊事件
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', () => updateDisplay(index));
    });

    // 為左右箭頭添加點擊事件
    document.getElementById('leftArrow')?.addEventListener('click', () => changeImage(-1));
    document.getElementById('rightArrow')?.addEventListener('click', () => changeImage(1));

    // 初始化第一張圖片的縮略圖邊框
    updateDisplay(0);
});

window.addEventListener('load', function () {
    console.log('頁面已完全加載');
    var reportButton = document.getElementById('reportButton');
    if (reportButton) {
        console.log('找到檢舉按鈕');
        reportButton.addEventListener('click', function () {
            console.log('檢舉按鈕被點擊');
            var inputOptions = JSON.parse(reportButton.dataset.reports);
            try {
                Swal.fire({
                    title: '檢舉',
                    html: `
                        <select id="reportReason" class="swal2-input">
                            <option value="" disabled selected>選擇檢舉原因</option>
                            ${Object.entries(inputOptions).map(([key, value]) => `<option value="${key}">${value}</option>`).join('')}
                        </select>
                        <textarea id="customReason" class="swal2-textarea" placeholder="輸入自定義原因" style="width: 80%; height: 80px; resize: none; margin: 1rem auto 0; display: block; overflow-x: hidden; padding: 0.75rem; box-sizing: border-box;"></textarea>
                    `,
                    showCancelButton: true,
                    confirmButtonText: '送出檢舉',
                    cancelButtonText: '取消',
                    preConfirm: () => {
                        const reportId = document.getElementById('reportReason').value;
                        const customReason = document.getElementById('customReason').value;
                        if (!reportId && !customReason) {
                            Swal.showValidationMessage('請選擇一個選項或輸入自定義原因');
                        }
                        return { reportId, customReason };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const { reportId, customReason } = result.value;
                        const description = customReason || '描述信息';

                        $.ajax({
                            url: reportButton.dataset.storeUrl,
                            method: 'POST',
                            data: {
                                report_id: reportId,
                                description: description,
                                _token: document.querySelector('meta[name="csrf-token"]').content,
                                product: reportButton.dataset.productId,
                            },
                            success: function (response) {
                                if (response.message === '你已檢舉過了') {
                                    Swal.fire({
                                        title: '你已檢舉過了',
                                        html: `檢舉原因：<br><p style="white-space: pre-wrap;">${response.description}</p>`,
                                        icon: 'info'
                                    });
                                } else {
                                    Swal.fire('檢舉已送出', response.message, 'success');
                                }
                            },
                            error: function (xhr) {
                                Swal.fire('錯誤', '無法提交檢舉', 'error');
                            }
                        });
                    }
                });
            } catch (error) {
                console.error('SweetAlert2 錯誤:', error);
            }
        });
    } else {
        console.error('未找到檢舉按鈕');
    }
});
