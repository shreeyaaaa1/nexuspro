<!DOCTYPE html>
<html>
<head>
  <title>NexusDoc</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> 
  <style>

    .jumbotron { 
      overflow: hidden;
      position: relative;
      background-color: #e9ecef; /* Off-white background for contrast */
      border-radius: 15px; /* Rounded corners */
      box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Subtle shadow */
    }
    .bubble {
      position: absolute;
      background-color: rgba(76, 175, 80, 0.2); /* Greenish with transparency */
      border-radius: 50%;
      opacity: 0; /* Initially hidden */
      animation: float 8s linear infinite; 
    }
    .bubble-1 {
      width: 50px;
      height: 50px;
      left: 10%;
      bottom: 20%;
      animation-delay: 0.1s; 
    }
    .bubble-2 {
      width: 80px;
      height: 80px;
      right: 15%;
      top: 30%;
      animation-delay: 0.5s;
    }
    .bubble-3 {
      width: 30px;
      height: 30px;
      left: 50%;
      top: 10%;
      animation-delay: 1.5s;
    }
    .bubble-4 {
      width: 60px;
      height: 60px;
      right: 5%;
      bottom: 5%;
      animation-delay: 2s;
    }
    .bubble-5 {
      width: 80px;
      height: 80px;
      right: 25%;
      bottom: 15%;
      animation-delay: 2.5s;
    }
    .bubble-6 {
      width: 40px;
      height: 40px;
      left: 30%;
      top: 5%;
      animation-delay: 2s;
    }
    .btn-primary {
      animation: pulse 1.5s infinite; 
    }
    @keyframes typing {
      from { width: 0 }
      to { width: 100% }
    }
    @keyframes blink-caret {
      from, to { border-color: transparent }
      50% { border-color: #000; }
    }
    @keyframes float {
      0% {
        opacity: 0;
        transform: translateY(0) scale(0.5);
      }
      50% {
        opacity: 0.8;
        transform: translateY(-100px) scale(1);
      }
      100% {
        opacity: 0;
        transform: translateY(-200px) scale(0.5);
      }
    }
    h1 { 
      font-family: 'Roboto', sans-serif;
      color: #91b88e; /* The color you requested */
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
      white-space: nowrap; /* Prevent text from wrapping */
      overflow: hidden; /* Hide text that overflows */
      border-right: 3px solid #000; /* Add the "cursor" */
      width: 0; /* Initially hide the text */
      animation: typing 4s steps(30, end) forwards, 
                 blink-caret 0.5s step-end infinite alternate;
    }
    h1:hover {
      transform: scale(1.1) rotate(3deg); /* Slight scale and rotate on hover */
      text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3); /* More pronounced shadow */
    }
    .lead {
      font-size: 1.2rem;
      color: #343a40; /* Dark gray color */
    }
    .btn-primary {
      animation: pulse 1.5s infinite; 
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-primary:hover {
      transform: translateY(-3px); /* Move slightly up on hover */
      box-shadow: 0 6px 12px rgba(0,0,0,0.2); /* More pronounced shadow */
    }
    /* Gradient background for the button */
    .btn-primary {
      background-image: linear-gradient(to right, #007bff, #0056b3); 
      border: none;
    }
      .card {
      background-color: #fff; /* White background for the cards */
      border: none; /* Remove default border */
      border-radius: 10px; /* Rounded corners */
      box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Subtle shadow */
      transition: transform 0.3s ease; /* Smooth transition for hover effect */
      overflow: hidden; /* To contain the expanding background */
    }

    .card:hover {
      transform: translateY(-5px); /* Lift up slightly on hover */
    }

    .card-body {
      position: relative; /* To position the expanding background */
    }

    .card-title {
      color: #28a745; /* Greenish title color */
    }

    /* Expanding background on hover */
    .card-body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #91b88e; /* Match the heading color */
      transform: scaleX(0); /* Initially hidden */
      transform-origin: left; /* Expand from the left */
      transition: transform 0.3s ease; /* Smooth transition */
      z-index: -1; /* Place behind the card content */
    }

    .card:hover .card-body::before {
      transform: scaleX(1); /* Expand to full width on hover */
    }

    .display-4 animate__animated animate__fadeInDown{
        font-family: monospace;
      white-space: nowrap;
      overflow: hidden;
      font: 1.2rem;
      border-right: 3px solid #000;
      width: 0;
      animation: typing 4s steps(30, end) forwards,
                 blink-caret 0.5s step-end infinite alternate;
    }
  </style>
</head>
<body>
  <div class="jumbotron text-center py-5 bg-light">
    <div class="shape shape-1"></div> 
    <div class="shape shape-2"></div> 
    <div class="bubble bubble-1"></div>
    <div class="bubble bubble-2"></div>
    <div class="bubble bubble-3"></div>
    <div class="bubble bubble-4"></div>
    <div class="bubble bubble-5"></div>
    <div class="bubble bubble-6"></div>

    <h1 class="display-4">Welcome to NexusDoc</h1>
    <img src="../assets/images/logo-large.png" alt="Logo" width="200" height="200" class="animate__animated animate__zoomIn">
    <p class="lead animate__animated animate__fadeInUp">A comprehensive platform for managing research project and data.</p>
    <?php if(!isLoggedIn()): ?>
      <a href="index.php?page=register" class="btn btn-primary btn-lg animate__animated animate__bounce">Get Started</a>
    <?php endif; ?>
    <div class="jumbotron text-center py-5 bg-light">
  </div>

<div class="row mt-5">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Data Management</h5>
        <p class="card-text">Efficiently organize and manage your research data with advanced metadata support.</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Collaboration</h5>
        <p class="card-text">Work   
 seamlessly with other researchers and share your findings.</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Visualization</h5>
        <p class="card-text">Transform your data into meaningful visualizations and insights.</p>
      </div>
    </div>
  </div>
  </div>
  </body>
</html>