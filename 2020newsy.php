 <!DOCTYPE html>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.0/css/bulma.css">
    <script >
function refreshIframe() {
    var ifr = document.getElementsByName('humanclock')[0];
    ifr.src = ifr.src;
    }
    </script>
<?php
// headline display

if (is_string($_GET["getheadlines"])) {
    
    $newsselection = $_GET["getheadlines"];
    $newsselection2 = $_GET["getheadlines2"];
    $today = date("Y-m-d H:i:s");
    
    $cSession = curl_init();
    curl_setopt($cSession,CURLOPT_URL,"https://newsapi.org/v2/top-headlines?sources=" . $newsselection . "&apiKey=((go to newsapi.org for your own key))");
    curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($cSession,CURLOPT_HEADER, false); 
    $headlines=curl_exec($cSession);
    curl_close($cSession);

    echo "<title>" . $newsselection2 . " | " . $today  . " | via Newsy</title>";
    echo "</head>";
    echo "<body>";
    echo "<script async src='https://static.addtoany.com/menu/page.js'></script>";
    
    echo "<div style='font-size:30px;'><a href='2020newsy.php'>start over</a> | " . $today . "<br>(tap/click image to go to article)<br> " . $newsselection2 . " | <a href='https://newsapi.org'>newsapi.org</a></div><br>";
    //echo $headlines;
    
    $newstring2 = json_decode($headlines);
    $arr2 = $newstring2->articles;

    foreach ($arr2 as &$value) {
            echo "<div style='font-size:20px; font-weight: bold;'>" . $value->title . "</div>";
            echo $value->description;
            echo "<br>";
            echo "<a href='" . $value->url . "'><img src='" . $value->urlToImage . "' style='height: 50%; width:50%;' target='_blank'></a>";
            echo "<div class='a2a_kit a2a_kit_size_24 a2a_default_style' data-a2a-url='" . $value->url . "' data-a2a-title='" . $value->title . "'>";
            echo "<a class='a2a_button_facebook'></a>";
            echo "<a class='a2a_button_twitter'></a>";
            echo "<a class='a2a_button_linkedin'></a>";
            echo "<a class='a2a_dd' href='https://www.addtoany.com/share'></a>";
            echo "</div>";
            echo "<hr style='height:2px;border-width:0;color:gray;background-color:gray'>";
    }   
    
} else {
     // base choice, sources
        $newsselection = "";
        echo "<title>newsy</title>";
        echo "<style>";
        echo "body {";
        echo "  background-color: linen;";
        echo "}";
        echo ".card-content {";
        echo "  color: maroon;";
        echo "}";
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "Credits: <a href='https://icons8.com/icon/80345/scroll'>Scroll icon by Icons8</a> <a href='https://bulma.io' target='_blank'>
<img src='https://bulma.io/images/made-with-bulma.png' alt='Made with Bulma' width='128' height='24'> <a href='https://newsapi.org'>Powered by News API</a>
</a>";
        echo "<div class='column is-three-quarters'>";

        $cSession = curl_init();
        curl_setopt($cSession,CURLOPT_URL,"https://newsapi.org/v2/sources?apiKey=((go to newsapi.org for your own key))");
        curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($cSession,CURLOPT_HEADER, false); 
        $result=curl_exec($cSession);
        curl_close($cSession);
        //echo $result;
        
        $newstring = json_decode($result);
        
        $arr = $newstring->sources;
        $names = array_column($arr, 'name');
        foreach ($arr as &$value) {
            echo "<div class='card'>";
            echo "<header class='card-header'>";
            echo "<p class='card-header-title'>";
            echo $value->name;
            echo "</p>";
            echo "<a href='https://democritus.biz/2020newsy.php?getheadlines=" . $value->id . "&getheadlines2=" . $value->name . "' class='card-header-icon' aria-label='more options'>";
              echo "get headlines<span class='icon'><img src='data:image/png;base64,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'/></span>";
            echo "</a>";
            echo "</header>";           
            echo "<br>";
              echo "<div class='card-content'>";
            echo "<div class='content'>";
            echo $value->description;
            echo "</div>";
           echo "</div>";
           echo "<footer class='card-footer'>";
            echo "<a href='" . $value->url . "' class='card-footer-item'>" . $value->url . "</a>";
           echo "</footer>";
            echo "</div>";
            echo "<br>";
    }   
        echo "</div>"; 
}
?>

<!--
    <section class="section section-light-grey is-medium">
        <div class="container">
            <div class="columns mt-80">
                <div class="column is-one-third">
                </div>
                <div class="column">
                    <div class="feature-card is-bordered has-text-centered revealOnScroll delay-2" data-animation="fadeInLeft">
                        <div class="card-text" align="center">
                        </div>
                        <div class="card-action">
                            Humanclock.com has ruled the web<br>since the early days. <a onclick="refreshIframe();">refresh</a>
                            <iframe name="humanclock" src="https://api.humanclock.com/iframe.php?mode=mdou" style="width:265px;height:250px;border:0px;margin:0px;overflow:hidden" frameborder="0" scrolling="no"></iframe>
                        </div>
                    </div>
                </div>
                <div class="column">
                </div>
            </div>
        </div>
    </section>
-->
        
</body>
</html>
