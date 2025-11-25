<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>SEO trái cây sạch | Fruitables</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hướng dẫn tối ưu SEO cho cửa hàng trái cây sạch Fruitables: từ nghiên cứu từ khoá, cấu trúc URL thân thiện đến tối ưu hình ảnh và tốc độ tải trang.">
    <meta name="keywords" content="trái cây sạch, seo trái cây, trái cây hữu cơ, trái cây nhập khẩu, mua trái cây online">
    <meta property="og:title" content="SEO trái cây sạch cho Fruitables">
    <meta property="og:description" content="Checklist SEO chi tiết giúp gian hàng trái cây của bạn nổi bật trên Google và mạng xã hội.">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('seo.landing') }}">
    <meta property="og:image" content="{{ asset('img/seo-fruitables.jpg') }}">
    <link rel="canonical" href="{{ route('seo.landing') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    @include('client.layout.header')

    <div style="margin-top: 140px" class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <p class="text-uppercase text-primary fw-bold">SEO Checklist</p>
                <h1 class="fw-bold mb-3">SEO trái cây sạch: tối ưu nội dung và chia sẻ mạng xã hội</h1>
                <p class="lead">Trang này được tối ưu với thẻ meta, Open Graph và URL thân thiện để làm mẫu kiểm tra bằng SEO Quake. Bạn có thể sao chép checklist và áp dụng cho từng trang sản phẩm.</p>

                <div class="bg-light rounded p-4 mb-4">
                    <h2 class="h4">1. Nghiên cứu từ khoá</h2>
                    <ul class="mb-0">
                        <li>Ưu tiên các cụm từ dài: "mua trái cây sạch online", "trái cây nhập khẩu giá tốt".</li>
                        <li>Đặt từ khoá chính trong <strong>title</strong>, mô tả, heading H1-H2 và tên file ảnh.</li>
                    </ul>
                </div>

                <div class="bg-light rounded p-4 mb-4">
                    <h2 class="h4">2. Cấu trúc URL &amp; liên kết nội bộ</h2>
                    <ul class="mb-0">
                        <li>Sử dụng URL thân thiện: <code>/product/xoai-cat-hoa-loc-123</code>.</li>
                        <li>Thêm liên kết tới danh mục, bài viết hướng dẫn bảo quản trái cây.</li>
                        <li>Tạo sitemap.xml và robots.txt để bot dễ thu thập.</li>
                    </ul>
                </div>

                <div class="bg-light rounded p-4 mb-4">
                    <h2 class="h4">3. Tối ưu tốc độ &amp; hình ảnh</h2>
                    <ul class="mb-0">
                        <li>Nén ảnh webp/jpg, dùng kích thước phù hợp và thuộc tính <code>alt</code> mô tả.</li>
                        <li>Sử dụng CDN cho thư viện tĩnh và lazy load cho banner.</li>
                    </ul>
                </div>

                <div class="bg-light rounded p-4 mb-4">
                    <h2 class="h4">4. Khả năng chia sẻ</h2>
                    <p>Nhấn vào nút bên dưới để kiểm tra hiển thị khi chia sẻ lên Facebook.</p>
                    <a class="btn btn-primary me-2" target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('seo.landing')) }}">
                        <i class="fab fa-facebook-f me-1"></i> Chia sẻ Facebook
                    </a>
                    <a class="btn btn-outline-secondary" href="mailto:?subject=Chia sẻ bài SEO trái cây&body={{ urlencode(route('seo.landing')) }}">
                        <i class="fa fa-envelope me-1"></i> Gửi email
                    </a>
                </div>

                <div class="bg-white border rounded p-4">
                    <h2 class="h4">Schema JSON-LD</h2>
                    <p class="mb-3">Thêm schema bài viết để cải thiện hiển thị trên kết quả tìm kiếm.</p>
                    <pre class="bg-light p-3 rounded small"><code>{
"@context": "https://schema.org",
"@type": "Article",
"headline": "SEO trái cây sạch: tối ưu nội dung và chia sẻ",
"author": {"@type": "Organization", "name": "Fruitables"},
"url": "{{ route('seo.landing') }}",
"image": "{{ asset('img/seo-fruitables.jpg') }}",
"description": "Checklist SEO cho cửa hàng trái cây sạch Fruitables"
}</code></pre>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="rounded border p-4 mb-4">
                    <h3 class="h5">Checklist nhanh</h3>
                    <ul class="list-unstyled mb-0">
                        <li>✔️ Thẻ meta title, description</li>
                        <li>✔️ Thẻ Open Graph đầy đủ</li>
                        <li>✔️ URL thân thiện</li>
                        <li>✔️ Nút chia sẻ mạng xã hội</li>
                        <li>✔️ robots.txt &amp; sitemap.xml</li>
                    </ul>
                </div>
                <div class="rounded border p-4">
                    <h3 class="h5">Nhận tư vấn miễn phí</h3>
                    <p>Đăng ký nhận ebook SEO trái cây sạch kèm mẫu nội dung tối ưu.</p>
                    <form method="post" action="{{ route('newsletter.subscribe') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required placeholder="ban@domain.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tên</label>
                            <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A">
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('client.layout.footer')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
