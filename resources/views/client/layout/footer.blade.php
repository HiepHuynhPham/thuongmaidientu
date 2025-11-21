<body>
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt3 mt-3">
        <div class="container">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <a href="/">
                            <h1 class="text-primary mb-0">Fruitables</h1>
                            <p class="text-secondary mb-0">Sản phẩm tươi</p>
                        </a>
                    </div>
                    <div style="margin-left: 650px;" class="col-lg-3">
                        <div class="d-flex justify-content-end pt-3">
                            <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Tại sao mọi người thích chúng tôi!</h4>
                        <p class="mb-4">Chúng tôi luôn mang đến cho bạn những trái cây tươi ngon, chất lượng
                            nhất. Được lựa chọn kỹ càng, nguồn gốc rõ ràng và an toàn cho
                            sức khỏe. Giao hàng nhanh chóng và giá cả hợp lý.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Thông tin cửa hàng</h4>
                        <a class="btn-link" href="">Giới thiệu</a>
                        <a class="btn-link" href="">Liên hệ với chúng tôi</a>
                        <a class="btn-link" href="">Chính sách bảo mật</a>
                        <a class="btn-link" href="">Điều khoản & Điều kiện</a>
                        <a class="btn-link" href="">Chính sách trả hàng</a>
                        <a class="btn-link" href="">Câu hỏi thường gặp & Trợ giúp</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Tài khoản</h4>
                        <a class="btn-link" href="">Tài khoản của tôi</a>
                        <a class="btn-link" href="">Chi tiết cửa hàng</a>
                        <a class="btn-link" href="">Giỏ hàng</a>
                        <a class="btn-link" href="">Danh sách mong muốn</a>
                        <a class="btn-link" href="">Lịch sử đơn hàng</a>
                        <a class="btn-link" href="">Đơn hàng quốc tế</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Fruitables
                            shop</a>, Mọi quyền được bảo lưu.</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->
    <div id="chatbox" style="position: fixed; bottom: 20px; right: 20px; width: 300px; height: 380px; background: white; border-radius: 12px; box-shadow: 0 0 10px #aaa; display: none; flex-direction: column; z-index: 9999;">
        <div style="padding:10px;font-weight:bold;background:#0099ff;color:white;display:flex;justify-content:space-between;align-items:center;">
            <span>Live Chat Support</span>
            <button onclick="closeChat()" style="background:transparent;border:none;color:white;font-size:18px;">▼</button>
        </div>
        <div id="chat-content" style="padding:10px;height:260px;overflow-y:auto;"></div>
        <div style="display:flex;border-top:1px solid #ddd;">
            <input id="chat-input" style="flex:1;padding:10px;border:none;" />
            <button onclick="sendMsg()" style="padding:10px;background:#0099ff;color:white;border:none;">Gửi</button>
        </div>
    </div>
    <button id="chat-open-btn" onclick="openChat()" style="position: fixed; bottom: 100px; right: 20px; width: 56px; height: 56px; border-radius: 50%; background:#0099ff; color: white; border:none; font-size:22px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); z-index: 9998;">
        💬
    </button>
    <script>
    function openChat() {
        var box = document.getElementById('chatbox');
        var btn = document.getElementById('chat-open-btn');
        if (!box) return;
        box.style.display = 'flex';
        if (btn) btn.style.display = 'none';
    }
    function sendMsg() {
        var input = document.getElementById('chat-input');
        var content = document.getElementById('chat-content');
        if (!input || !content) return;
        var text = (input.value || '').trim();
        if (text === '') return;
        content.innerHTML += '<div><b>Bạn:</b> ' + text.replace(/</g,'&lt;') + '</div>';
        content.innerHTML += '<div><b>Bot:</b> Cảm ơn bạn! Chúng tôi sẽ hỗ trợ ngay.</div>';
        input.value = '';
        content.scrollTop = content.scrollHeight;
    }
    function closeChat() {
        var box = document.getElementById('chatbox');
        var btn = document.getElementById('chat-open-btn');
        if (!box) return;
        box.style.display = 'none';
        if (btn) btn.style.display = 'inline-block';
    }
    </script>
</body>