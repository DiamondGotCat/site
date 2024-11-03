<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>from URL - KAMU</title>
      <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
      <script src="https://cdn.tailwindcss.com"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=M+PLUS+2:wght@100..900&display=swap" rel="stylesheet">
      <style>
      body {
        font-family: "M PLUS 2", system-ui;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
      }
      .m-plus-2-black {
        font-family: "M PLUS 2", system-ui;
        font-optical-sizing: auto;
        font-weight: 900;
        font-style: normal;
      }
      </style>
  </head>
<body>

  <header>

    <div class="navbar bg-base-100">
      <div class="navbar-start">
        <div class="dropdown">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h7" />
            </svg>
          </div>
          <ul
            tabindex="0"
            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
            <li><a href="/">HOME</a></li>
          </ul>
        </div>
      </div>
      <div class="navbar-center">
        <a href="/" class="btn btn-ghost text-xl">KAMU</a>
      </div>
      <div class="navbar-end">
        <!-- Navbar End -->
      </div>
    </div>

  </header>

  <main>

    <div class="hero bg-base-200 min-h-screen">
      <div class="hero-content text-center">
        <div class="max-w-md">
            <h1 class="text-5xl font-bold">from URL</h1>

            <div class="divider"></div>
            
            <form action="../process" method="GET">
                <div class="flex basis-0">
                    <input type="url" name="url" placeholder="Enter URL..." class="input input-bordered w-full max-w-xs" />
                    <button type="submit" class="btn btn-primary">Shorten</button>
                </div>
            </form>

            <div class="divider">OR</div>

            <a href="/u/"><button class="btn btn-primary">Use</button></a>

        </div>
      </div>
    </div>

  </div>

  </main>

  <footer>

    <footer class="footer footer-center bg-base-200 text-base-content rounded p-10">
      <aside>
        <p>Copyright &copy;2024 - All right reserved by DiamondGotCat</p>
      </aside>
    </footer>

  </footer>

</body>
</html>