<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>權限不足</title>
    {{-- 你可以引入你專案正在使用的 CSS 框架，例如 Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="alert alert-danger" role="alert" style="padding: 2rem;">
            <h4 class="alert-heading">權限不足 (403 Forbidden)</h4>
            <p>很抱歉，您沒有執行此項操作所需要的權限。</p>
            <hr>
            {{-- url()->previous() 會自動抓取使用者是從哪個頁面來的 --}}
            <a href="javascript:history.back()" class="btn btn-primary">返回上一頁</a>
        </div>
    </div>
</body>
</html>