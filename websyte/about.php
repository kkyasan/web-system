<!DOCTYPE html>
<html>
<head>
  <title>About - The Bookhive</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="header">  
    <h1><strong>THE BOOKHIVE</strong></h1>
    <img class="logo" src="logo.svg" alt="The Bookhive logo">
    <a class="library" href="profile.html">Go to Library →</a>
    <button class="menu-btn" onclick="toggleMenu()">☰</button>
    <nav id="navbar">
      <a href="landd.html" onclick="toggleMenu()">Bookhive</a>
      <a href="home.html" onclick="toggleMenu()">Home</a>
      <a href="profile.html" onclick="toggleMenu()">Library</a>
      <a href="about.html" onclick="toggleMenu()">About</a>
    </nav>
  </div>

  <div class="body about">
    <h2>About The Bookhive</h2>
    <p>The Bookhive is a book review site made for readers of dystopian fiction. Think of it as a reading journal where you can keep track of the worlds you want to visit and rate the ones you've finished.</p>

    <h3>What you can do</h3>
    <p>Browse a curated collection of dystopian books, add the ones that interest you to your To Be Read list, and rate the books you've read with stars. Everything lives in your personal library.</p>

    <h3>Why dystopian books?</h3>
    <p>Dystopian stories imagine societies gone wrong, and they make us think about power, freedom and what we would do in those worlds. Focusing on one genre keeps the collection tight and gives readers a place to connect over the same kind of stories.</p>

    <h3>Get started</h3>
    <p>Ready to find your next read? Head to the collection and add your first book.</p>
    <a class="add-btn" href="home.html">Browse the books</a>
  </div>

  <div class="footer">
    <footer>
      <p>&copy; 2026 The Bookhive. All rights reserved.<br>
      Explore dystopian worlds.</p>
    </footer>
  </div>

  <script>
    function toggleMenu() {
      document.getElementById("navbar").classList.toggle("active");
    }
  </script>
</body>
</html>