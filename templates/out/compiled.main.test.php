<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Graal - Bone</title>

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="templates/css/prism.css" />

    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 5rem;
        }

        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">GraalPHP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <main role="main" class="container">

        <div class="starter-template">
            <h1>< BONE /></h1>
            <p class="lead">Revolutionary templating system like no one</p>
        </div>

        <div class="container">
            <h1>#variables</h1>
            Like other template engine, Bone, use the classic "mustache" like system to display variables
            <pre><code class="language-php"><?php echo '{{ var }}' ;?></code></pre>
            which is filled in with this
            <pre><code class="language-php"> echo $var ;</code></pre>
            to call nested reference let's use the point
            <pre><code class="language-php"><?php echo '{{ var.reference }}' ;?></code></pre>
            or for the arrays, the classic squares
            <pre><code class="language-php"><?php echo '{{ var.reference[\'myKey\'] }}' ;?></code></pre>
            <pre><code class="language-php"><?php echo '{{ var.reference[11] }}' ;?></code></pre>
            you can use the brackets also to show out a function
            <pre><code class="language-php"><?php echo '{{ myFunc() }}' ;?></code></pre>
            and passing in, parameters or other variables
            <pre><code class="language-php"><?php echo '{{ substr(email,0,-8) }}' ;?></code></pre>
            this sounds familiar, isn't it ? but wait, now the cool coming !
            <h1 class="display-4 mt-4">the directives</h1>
            Bone, thanks to the "directives", interprets the html tags and its attributes to perform some functionalities.<br />
            stay and watch!
            <h1 class="mt-3">#for</h1>
            in the old style templates
            <pre><code class="language-markup"><!--<ul>
{% for i in items %}
    <li> <?php echo '{{ i.name }}' ;?> </li>
{% endfor %} 
</ul> 
--></code></pre>
            and now in <em>bone</em> !
            <pre><code class="language-markup"><!--<ul for="i" in="items"> 
    <li> <?php echo '{{ i.name }}' ;?> </li> 
</ul> 
--></code></pre>
            or in the classic coding
            <pre><code class="language-markup"><!--<ul for="( i=0 ; i < items.length ; i++ )"> 
    <li> <?php echo '{{ items[i].name }}' ;?> </li> 
</ul> 
--></code></pre>
            or also like the php foreach =>
            <pre><code class="language-markup"><!--<ul for="items" as="key,value"> 
    <li> <?php echo '{{ items[key].name }}' ;?> </li> 
</ul> 
--></code></pre>
        </div>
    </main>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="templates/js/prism.js"></script>
</body>

</html>