<!doctype html>
<html lang="en">

<head>
    <title>Laravel</title>
    <!-- Required meta tags -->
    <link rel="icon" href="/img/laravel.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #FFFFFF;
            font-family: 'Poppins', sans-serif;
        }

        a {
            text-decoration: none;
        }

        ul {
            list-style: disc;
            color: #e0ffff;
        }

        section {
            width: 100%;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            column-gap: 20px;
        }

        .container img {
            width: 300px;
        }

        .text {
            display: block;
            padding: 40px 40px;
            width: 450px;
        }

        .text h1 {
            color: #F9322C;
            font-size: 35px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .text p {
            font-size: 15px;
            color: #232323;
            margin-bottom: 15px;
            line-height: 1.5rem;
            margin-bottom: 15px;
        }

        .text .input-box {
            position: relative;
            display: flex;
            width: 100%;
        }

        .input-box input {
            width: 85%;
            height: 40px;
            padding: 5px 15px;
            font-family: 'Jost', sans-serif;
            font-size: 16px;
            color: #221e1e;
            border-radius: 5px 0px 0px 5px;
            border: 2px solid #F9322C;
            outline: none;
        }

        .input-box button {
            display: flex;
            width: 20%;
            border: 1px solid #F9322C;
            border-radius: 0px 5px 5px 0px;
            background: #F9322C;
            color: #e0ffff;
            font-size: 14px;
            font-weight: bold;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .menu {
            display: flex;
            flex-direction: column;
            margin-top: 15px;
            margin-left: 15px;
        }

        .menu li a {
            display: flex;
            font-size: 1rem;
            color: #F9322C;
            transition: 0.1s;
        }
        ul {
            list-style: none;
            }

        ul li a::before {
            content: "\2022";
            color: rgb(0, 0, 0);
            font-weight: bold;
            display: inline-block;
            width: 1em;
        }

        @media screen and (max-width:600px) {
            .container {
                display: flex;
                flex-direction: column-reverse;
            }

            .text,
            .image {
                width: 100%;
            }

            .container {
                min-width: 200px;
                padding: 40px 0px;
            }

            .text {
                display: block;
                width: 100%;
                padding: 20px 40px;
            }

            .image {
                display: flex;
                width: 200px;
                align-self: center;
                justify-content: center;
                margin: auto;
            }
        }
    </style>
</head>

<body>
    <section>
        <div class="container">
            <div class="text">
                <h1>Laravel Needs a System Update</h1>
                <p>The features inside the website need to be improved to gain support from the system.</p>
                <div class="input-box">
                    <input type="text" placeholder="Search...">
                    <button>Search</button>
                </div>
                <ul class="menu">
                    <li><a href="https://laravel.com/docs/">Go to Documentation</a></li>
                    <li><a href="https://laravel-news.com/">Visit our News</a></li>
                    <li><a href="https://laravel.com/">Contact support</a></li>
                </ul>
            </div>
            <div><img class="" src="/img/maintance.png" alt="">
            </div>
        </div>
        </div>
    </section>

</body>
</body>

</html>
