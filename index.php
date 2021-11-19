<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shorty | URL shortner</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap&text=ComingSoon...Made with ❤️ by Akash and Srikar" rel="stylesheet">
  <link rel="shortcut icon" href="https://img.icons8.com/color/50/000000/shorten-urls.png" type="image/x-icon">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Sacramento', cursive;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      width: 100vw;
      background: #0E141B;
      position: relative;
    }

    h1 {
      color: #fff;
      font-size: clamp(3rem, 10vw, 10rem);
      transition: transform .5s;
      cursor: pointer;
      position: relative;
    }

    h1::before {
      content: "";
      position: absolute;
      background-color: #fff;
      bottom: 10px;
      left: 0;
      height: 10px;
      width: 0;
      transition: all .5s;
      z-index: -1;
    }

    h1:hover {
      transform: scale(1.5);
    }

    h1:hover::before {
      width: 100%;
    }

    footer {
      position: absolute;
      bottom: 5px;
      color: #f3f3f3;
      font-size: clamp(1rem, 5vw, 2rem);
    }
  </style>
</head>

<body>
  <h1>Coming soon...</h1>

  <footer>
    <p>Made with ❤️ by Akash and Srikar</p>
  </footer>
</body>

</html>