<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDo App</title>
    <!--
    *   yield()：子ビューで定義したデータを表示する
    *   セクション名：styles を指定
    *   用途：javascriptライブラリー「flatpickr」のスタイルシートを指定
    -->
    @yield('styles')
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <header>
        <nav class="my-navbar">
            <a class="my-navbar-brand" href="/">ToDo App</a>
            <div class="my-navbar-control">
                @if(Auth::check())
                <span class="my-navbar-item">ようこそ, {{ Auth::user()->name }}さん</span>
                ｜
                <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @else
                <a class="my-navbar-item" href="{{ route('login') }}">ログイン</a>
                ｜
                <a class="my-navbar-item" href="{{ route('register') }}">会員登録</a>
                @endif
            </div>
        </nav>
    </header>
    <main>
        <!--
        *   yield()：子ビューで定義したデータを表示する
        *   セクション名：content を指定
        *   用途：タスクを追加するHTMLを表示する
        -->
        @yield('content')
    </main>
    <!--
    *   ログアウトのクリックイベント
    *   機能：ログアウトリンクのクリック時に真下のログアウトフォームを送信する
    *   用途：ログアウトを実施する
    -->
    @if(Auth::check())
    <script>
        document.getElementById('logout').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
    </script>
    @endif
    <!--
    *   yield()：子ビューで定義したデータを表示する
    *   セクション名：scripts を指定
    *   目的：flatpickr によるカレンダー形式による日付選択
    *   用途：javascriptライブラリー「flatpickr」のインポート
    -->
    @yield('scripts')
</body>

</html>