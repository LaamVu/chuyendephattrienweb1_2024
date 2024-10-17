document.addEventListener('DOMContentLoaded', function () {
    const dealsContainer = document.querySelector('.deals');
    const totalDeals = document.querySelectorAll('.deal').length;
    let currentIndex = 0;
    let autoSlideInterval;

    function slideDeals() {
        dealsContainer.style.transform = `translateX(-${currentIndex * 20}%)`;
    }

    function updateIndex(direction) {
        currentIndex += direction;

        // Giới hạn di chuyển bên phải
        if (currentIndex > totalDeals - 5) {
            currentIndex = totalDeals - 5; // Dừng ở cuối cùng
        }
        // Giới hạn di chuyển bên trái
        else if (currentIndex < 0) {    
            currentIndex = 0; // Dừng ở đầu tiên
        }

        slideDeals();
    }

    // Tự động trượt qua mỗi 3 giây
    autoSlideInterval = setInterval(() => updateIndex(1), 3000);

    // Xử lý sự kiện click trên các mũi tên
    document.querySelector('.left-arrow').addEventListener('click', () => {
        updateIndex(-1);
        resetAutoSlide();
    });
    document.querySelector('.right-arrow').addEventListener('click', () => {
        updateIndex(1);
        resetAutoSlide();
    });

    // Dừng tự động trượt khi rê chuột vào sản phẩm
    dealsContainer.addEventListener('mouseenter', () => {
        clearInterval(autoSlideInterval);
    });

    // Tiếp tục tự động trượt khi chuột rời khỏi sản phẩm
    dealsContainer.addEventListener('mouseleave', () => {
        autoSlideInterval = setInterval(() => updateIndex(1), 5000);
    });

    // Rê chuột vào bên trái hoặc bên phải để điều khiển
    dealsContainer.addEventListener('mousemove', (e) => {
        const dealsWidth = dealsContainer.offsetWidth;
        const mouseX = e.clientX - dealsContainer.getBoundingClientRect().left;
        const threshold = dealsWidth / 2;

        if (mouseX < threshold) {
            updateIndex(-1); // Di chuyển sang trái
        } else {
            updateIndex(1); // Di chuyển sang phải
        }
    });

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(() => updateIndex(1), 5000);
    }
});
