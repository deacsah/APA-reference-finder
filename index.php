<?php
function tab2space($text, $tab = 4, $nbsp = FALSE) {
    return str_replace("\t", "<span class='tab'></span>", $text);
}
function replaceQuotes($text) {
    return str_replace(["\""], ["&quot;"], $text);
}
if (isset($_POST['text']) && !empty($_POST['text'])) {
    $origText = $_POST['text'];
    // $text = str_replace("\n", "", $_POST['text']);
    
    $regexOut = "\(([^\)]+?),(\s?)\d{4}\)";
    // $regexOut = "\(([^\)]+?), \d{4}[12][0-9]{3}\)";
    $regexIn = "(?:[A-Z][^ ]+?) \((\d{4})\)|(?:[A-Z][^ ]+?)(?: et al\. | (and|&) [A-Z][^ ]+? )\((\d{4})\)";


    $text = preg_replace("/(\r?\n){1,}/", " ", $_POST['text']);
    $has_matches = preg_match_all('/'.$regexOut.'/', $text, $matches_out);
    $has_matches2 = preg_match_all('/'.$regexIn.'/', $text, $matches_out2);
    $has_matches3 = preg_match_all("/(".$regexOut."|".$regexIn.")/", $text, $matches_out3);

    $outTextRefsCount = count($matches_out[0]);
    $inTextRefsCount = count($matches_out2[0]);
    $allTextRefsCount = count($matches_out3[0]);
    $outTextRefs = array_count_values($matches_out[0]);
    $inTextRefs = array_count_values($matches_out2[0]);
    $allTextRefs = array_count_values($matches_out3[0]);
} 
?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="APA referentie zoeker">
    <meta name="author" content="opperbazen.nl">
    <title>APA Referentie Zoeker</title>
    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/freelancer.css" rel="stylesheet">
    <!-- Custom Fonts --> 
    <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49118761-4', 'auto');
  ga('send', 'pageview');

</script>
    
</head>
<body id="page-top" class="index">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top"><i class="fa fa-quote-left"></i> APA Referentie Zoeker</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="http://opperbazen.nl/contact">Bug doorgeven?</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav> 
    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>Voer de tekst in met de literatuur verwijzingen</p>
                    <form method="post">
                        <textarea name="text" class="main-input" placeholder="Voer hier de tekst in"><?php echo isset($text) ? $origText : ''; ?></textarea>
                        <hr class="star-light">
                        <input type="hidden" value="<?php echo isset($text) ? replaceQuotes(tab2space(nl2br($origText))) : ''; ?>" class="hidden-input"></input>
                        <button  type="submit" class="btn btn-success submitter"><i class="fa fa-search"></i> <span>ZOEKEN</span></button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <?php if (!empty($text)): ?>

    <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container"> 
            <a data-toggle="modal" class="portfolio-link read" href="#textModal">
                <h3 class="text-center">
                    <i class="fa fa-search-plus fa-1x"></i>
                    Bekijk tekst 
                </h3>
            </a>  
            <div class="row">
                <div class="col-md-6 col-md-push-3">
                    <?php if (isset($matches_out3[0]) && !empty($matches_out3[0])): ?>
                        <div class="well">
                            <h4><?php echo $allTextRefsCount ?> referenties in totaal</h4>
                            <ul class="list-group">
                            <?php foreach ($allTextRefs as $key3 => $value3): ?>
                                <?php if (!empty($value3)): ?>
                                    <li class="list-group-item">
                                        <?php if ($value3 > 1): ?>
                                            <span class="badge"><?php echo $value3 ?>x</span>     
                                        <?php endif ?> 
                                        <?php echo $key3 ?>
                                        <br/>
                                        <a target="_blank" class="google-link" href="https://scholar.google.nl/scholar?q='<?php echo urlencode($key3); ?>'">
                                            <i class="fa fa-graduation-cap" aria-hidden="true"></i> Google scholar
                                        </a>
                                        <a target="_blank" class="google-link" href="https://www.google.nl/search?q='<?php echo urlencode($key3); ?>'">
                                            <i class="fa fa-google" aria-hidden="true"></i> Google <span></span>
                                        </a>
                                        <a data-toggle="modal" data-value="<?php echo $key3 ?>" class="searchInText google-link" href="#textModal">
                                            <i class="fa fa-search" aria-hidden="true"></i> Zoek in tekst
                                        </a>
                                    </li>
                                <?php endif ?>
                            <?php endforeach ?>
                            </ul>
                            <p class="hint text-center" style="color:#666; margin: 10px 0 0 0; font-size: 0.9em;"><i class="fa fa-star"></i> De resultaten hebben de volgorder waarop ze gevonden zijn.</p>
                        </div>
                    <?php else: ?>
                        <p class="text-center"><em>Er zijn geen referenties tussen haakjes gevonden.</em></p>
                    <?php endif ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php if (isset($matches_out[0]) && !empty($matches_out[0])): ?>
                        <div class="well">
                            <h4><?php echo $outTextRefsCount ?> Referenties tussen haakjes</h4>
                            <ul class="list-group">
                            <?php foreach ($outTextRefs as $key => $value): ?>
                                <?php if (!empty($value)): ?>
                                    <li class="list-group-item">
                                        <?php if ($value > 1): ?>
                                            <span class="badge"><?php echo $value ?>x</span>     
                                        <?php endif ?> 
                                        <?php echo $key ?>
                                        <br/>
                                        <a target="_blank" class="google-link" href="https://scholar.google.nl/scholar?q=<?php echo $key; ?>">
                                            <i class="fa fa-graduation-cap" aria-hidden="true"></i> Google scholar
                                        </a>
                                        <a target="_blank" class="google-link" href="https://www.google.nl/search?q=<?php echo $key; ?>">
                                            <i class="fa fa-google" aria-hidden="true"></i> Google <span></span>
                                        </a>
                                        <a data-toggle="modal" data-value="<?php echo $key ?>" class="searchInText google-link" href="#textModal">
                                            <i class="fa fa-search" aria-hidden="true"></i> Zoek in tekst
                                        </a>
                                    </li>
                                <?php endif ?>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <p class="text-center"><em>Er zijn geen referenties tussen haakjes gevonden.</em></p>
                    <?php endif ?>
                </div>
                <div class="col-md-6">
                    <?php if (isset($matches_out2[0]) && !empty($matches_out2[0])): ?>
                        <div class="well">
                            <h4><?php echo $inTextRefsCount ?> Referenties in tekst</h4>
                            <ul class="list-group">
                            <?php foreach ($inTextRefs as $key2 => $value2): ?>
                                <?php if (!empty($value2)): ?>
                                    <li class="list-group-item">  
                                        <?php if ($value2 > 1): ?>
                                            <span class="badge"><?php echo $value2 ?>x</span>     
                                        <?php endif ?> 
                                        <?php echo $key2 ?>
                                        <br/>
                                        <a target="_blank" class="google-link" href="https://scholar.google.nl/scholar?q=<?php echo $key2; ?>">
                                            <i class="fa fa-graduation-cap" aria-hidden="true"></i> Google scholar
                                        </a>                                        
                                        <a target="_blank" class="google-link" href="https://www.google.nl/search?q=<?php echo $key2; ?>">
                                            <i class="fa fa-google" aria-hidden="true"></i> Google <span></span>
                                        </a>
                                        <a data-toggle="modal" data-value="<?php echo $key2 ?>" class="searchInText google-link" href="#textModal">
                                            <i class="fa fa-search" aria-hidden="true"></i> Zoek in tekst
                                        </a>
                                    </li>
                                <?php endif ?> 
                            <?php endforeach ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <p class="text-center"><em>Er zijn geen tekst verwijzingen gevonden.</em></p>
                    <?php endif ?>  
                </div>
            </div>  
 

        </div> 
    </section> 
    <div aria-hidden="true" role="dialog" tabindex="-1" id="textModal" class="portfolio-modal modal fade" style="display: none;">
        <div class="modal-content">
            <div data-dismiss="modal" class="close-modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row"> 
                    <div class="col-lg-10 col-lg-offset-1">
                        <div class="modal-body">
                            <h2>Bekijk tekst</h2>
                            <hr class="star-primary">
                            <div class="main-output">
                                <div class="backdrop">
                                    <p class="highlights">
                                        <!-- cloned text with <mark> tags here -->
                                    </p>
                                </div>
                            </div>
                            <ul class="list-inline item-details">
                                <li>Tip:
                                    <strong>Kopieer direct van het word bestand om de opmaak te behouden.</strong>
                                </li>
                            </ul>
                            <button data-dismiss="modal" class="btn btn-default" type="button"><i class="fa fa-times"></i> SLUITEN</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?> 
    <!-- Footer -->
    <footer class="text-center"> 
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4 col-md-push-4">
                        <h3>Over APA Referentie Zoeker</h3>
                        <p>Pro scriptje om een lijst te maken van APA literatuur verwijzingen in een tekst</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; Opperbazen <?php echo date('Y') ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll visible-xs visible-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>
    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/freelancer.js"></script>
    <?php if (!empty($text)): ?>
        <script type="text/javascript">
            $(document).ready(function() {
                handleInput();
                $(".portfolio-link.read").click(function() {
                    handleInput();
                });
                $(".searchInText").click(function() {
                    var query = $(this).data('value');
                    searchInText(query);
                });
            });
            function handleInput() {
                var text = $('.hidden-input').val();
                var highlightedText = applyFirstHighlights(text);
                var highlightedText = applySecondHighlights(highlightedText);
                $('.highlights').html(highlightedText);
                // $('.main-output').html(highlightedText);
            }        
            function searchInText(query) {
                var text = $('.hidden-input').val();
                var re = new RegExp(escapeRegExp(query),"g");
                var highlightedText = text.replace(re, '<span class="query">$&</span>');
                $('.highlights').html(highlightedText);
            }        
            function escapeRegExp(str) {
                return str.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"); // $& means the whole matched string
            } 
            function applyFirstHighlights(text) {
                return text.replace(/(\r?\n){1,}/g, ' ').replace(/\(([^\)]+?),(\s?)\d{4}\)/g, '<mark>$&</mark>');
            }
            function applySecondHighlights(text) {
                return text.replace(/(\r?\n){1,}/g, ' ').replace(/(?:[A-Z][^ ]+?) \((\d{4})\)|(?:[A-Z][^ ]+?)(?: et al\. | (and|&) [A-Z][^ ]+? )\((\d{4})\)/g, '<span>$&</span>');
            }
        </script>
    <?php endif ?>  
</body>
</html>
