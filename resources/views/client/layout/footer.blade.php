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
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Nhận tin khuyến mãi</h4>
                        <p>Đăng ký nhận ưu đãi và bài viết dinh dưỡng. Email sẽ được thêm vào danh sách Mailchimp.</p>
                        <form class="mb-2" method="post" action="{{ route('newsletter.subscribe') }}">
                            @csrf
                            <div class="mb-2">
                                <input type="email" name="email" class="form-control" required placeholder="you@example.com">
                            </div>
                            <div class="mb-2">
                                <input type="text" name="name" class="form-control" placeholder="Tên của bạn (không bắt buộc)">
                            </div>
                            <button class="btn btn-primary w-100" type="submit">Đăng ký ngay</button>
                        </form>
                        @if(session('success'))
                            <p class="text-success small mb-0">{{ session('success') }}</p>
                        @elseif(session('error'))
                            <p class="text-danger small mb-0">{{ session('error') }}</p>
                        @endif
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
    <div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat"></div>
    <script>
        const chatbox = document.getElementById('fb-customer-chat');
        if (chatbox) {
            chatbox.setAttribute("page_id", "{{ env('FACEBOOK_PAGE_ID', '100249304491708') }}");
            chatbox.setAttribute("attribution", "biz_inbox");
        }

        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v18.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    @php
        $tawkProperty = env('TAWK_PROPERTY_ID');
        $tawkWidget = env('TAWK_WIDGET_ID');
    @endphp
    @if($tawkProperty && $tawkWidget)
    <script async src="https://embed.tawk.to/{{ $tawkProperty }}/{{ $tawkWidget }}" charset="UTF-8" crossorigin="*"></script>
    @endif
    <a href="{{ env('MESSENGER_LINK', 'https://m.me/916138074910459') }}" target="_blank" style="position:fixed; bottom:100px; right:20px; background:#0084ff; color:white; padding:12px 15px; border-radius:8px; z-index:9999; text-decoration:none;">Chat Messenger</a>
    @if(env('ZALO_OA_ID'))
    <div class="zalo-chat-widget" data-oaid="{{ env('ZALO_OA_ID') }}" data-welcome-message="Xin chào! Tôi có thể giúp gì cho bạn?" data-autopopup="0" data-width="350" data-height="420"></div>
    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
    @endif
