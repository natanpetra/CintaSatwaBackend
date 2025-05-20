<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page:title')</title>
    <style>
        /** Define default page margins to 0 for full control over header and footer **/
        @page {
    margin: 0px 15px 0px 15px; /* Margin untuk halaman PDF */
}

/** Definisikan margin tubuh halaman PDF **/
body {
    margin-top: 160px; /* Sesuaikan margin atas untuk memberikan ruang bagi header */
    margin-left: 2cm;
    margin-right: 2cm;
    margin-bottom: 80px; /* Ruang untuk footer */
}

/** Aturan untuk header **/
header {
    position: fixed;
    top: 0cm; /* Menempatkan header di bagian atas */
    left: 0cm;
    right: 0cm;
    height: 150px;

    /** Gaya personal tambahan **/
    background-image: url("data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/header.jpg'))) }}");
    background-size: cover;
    background-repeat: no-repeat;
    color: white;
    text-align: center;
    line-height: 1.5cm;
}

/** Aturan untuk footer **/
footer {
    position: fixed; 
    width: 100%;
    bottom: 0cm; /* Menempatkan footer di bagian bawah */
    left: 0cm; 
    right: 0cm;
    height: 80px;

    /** Gaya personal tambahan **/
    background-image: url("data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/footer.jpg'))) }}");
    background-size: cover;
    background-repeat: no-repeat;
    color: white;
    text-align: center;
    line-height: 1.5cm;
}

/** Aturan untuk konten utama **/
main {
    break-inside: avoid; /* Mencegah konten di dalam <main> terputus secara acak */
    margin-top: 10px; /* Atur margin atas untuk <main> */
}

/** Aturan untuk konten dalam <main> **/
.content {
    margin-top: 10px; /* Margin atas untuk konten */
}

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
            width: 50%;
            height: auto;
        }

        .title { text-align: center; margin-top: -5px; }
        .subtitle { text-align: center; }

        table { width: 100%; }
        table.table-items,
        table.table-summaries,
        table.table-full-border,
        table.table-additional { 
            border-collapse: collapse; 
            border: 1px solid black; 
        }
        table.table-items thead tr th,
        table.table-items tbody tr td { 
            border-right: 1px solid black; 
        }
        table.table-items tfoot tr td { 
            border-top: 1px solid black;
            border-right: 1px solid black; 
        }
        table.table-items td,
        table.table-summaries td,
        table.table-full-border td { 
            padding: 0px 10px; 
        }

        .label { font-weight: bold; }
        .text-align-center { text-align: center; }
        .text-align-right { text-align: right; }
    </style>
</head>
<body>
    <!-- Watermark -->
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/background.png'))) }}" alt="Watermark" class="watermark">

    <!-- Header -->

        <header>
        </header>

        <div class="content">
        @yield('page:header-content')
        </div>


        <footer>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
        @yield('page:content')
        </main>
</body>
</html>
