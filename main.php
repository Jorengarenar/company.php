<?php
define("ROOT", "../.."); // because this file is sourced from /l/lang/index.php
define("LANG_DIR", ROOT . "/l/" . LANG);

$text = json_decode(file_get_contents(LANG_DIR."/text.json"), true);
?>

<?php
function sanitize($str)
{
    return preg_replace('/ ([a-z]) /', " $1&nbsp;", $str);
}

function countFolder($dir) {
    return (count(scandir($dir)) - 2);
}
?>

<?php
function minify_html($buffer)
{
    $search = array(
        '/(\n|^)(\x20+|\t)/',
        '/(\n|^)\/\/(.*?)(\n|$)/',
        '/\n/',
        '/\<\!--.*?-->/',
        '/(\x20+|\t)/',   # delete multispace (Without \n)
        '/\>\s+\</',      # strip whitespaces between tags
        '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
        '/=\s+(\"|\')/'   # strip whitespaces between = "'
    );

    $replace = array( "\n", "\n", " ", "", " ", "><", "$1>", "=$1");

    return preg_replace($search, $replace, $buffer);
}

// ob_start("minify_html");
?>

<!DOCTYPE html>
<html data-scroll="false" lang="<?php echo LANG; ?>">
<head>
  <meta charset="UTF-8">
  <title>Company</title>
  <meta name="author" content="Jorengarenar">
  <meta name="description" content="<?php echo $text["html"]["description"] ?>">
  <meta name="keywords" content="<?php echo $text["html"]["keywords"] ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="<?php echo ROOT;?>">
  <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500" rel="stylesheet" type="text/css" />
  <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="script.js"></script>
</head>
<body onload="init()">

  <nav>
    <a id="logo" href="/<?php echo LANG_DIR; ?>/"><img src="assets/logo.png" /></a>
    <input id="menu" type="checkbox" autocomplete="off" />

    <div>
      <div class="links">
        <a href=""><?php echo $text["loc"]["store"] ?></a>
        <a href="<?php echo LANG_DIR; ?>/#about"><?php echo $text["loc"]["about"] ?></a>
        <a href="<?php echo LANG_DIR; ?>/#products"><?php echo $text["loc"]["products"] ?></a>
        <a href="<?php echo LANG_DIR; ?>/#contact"><?php echo $text["loc"]["contact"] ?></a>
        <a href=""><svg class="icon"><use xlink:href="assets/icons.svg#fb" /></svg></a>
        <a href=""><svg class="icon"><use xlink:href="assets/icons.svg#linkedin" /></svg></a>
      </div>
      <details id="language">
        <summary>
          <svg class="icon"><use xlink:href="assets/icons.svg#<?php echo LANG; ?>" /></svg>
        </summary>
        <a href="/l/de/">Deutsch</a>
        <a href="/l/en/">English</a>
        <a href="/l/pl/">Polski</a>
        <a href="/l/ru/">Русский</a>
      </details>
    </div>

    <label for="menu">
      <svg class="icon"><use xlink:href="assets/icons.svg#hamburger" /></svg>
    </label>
  </nav>
  <div><!-- spacer --></div>

  <p id="quote"><?php echo $text["quote"] ?></p>
  <div class="slider">
    <div>
<?php
foreach(scandir(ROOT."/assets/slider") as $img) {
    echo '<img src="/assets/slider/'.$img.'" />';
}
?>
    </div>
  </div>

  <main>
    <div id="products">
      <div id="product-list">
<?php
foreach($text["products"] as $key => $value) {
    echo '<div onclick="switchProduct(this)" data-bar="' . $key . '">
        <img src="assets/tiles/' . $key . '.png" loading="lazy" />
        <h2>' . $value["name"] . '</h2>
        </div>';
}
?>
      </div>
<?php
foreach($text["products"] as $key => $value) {
    $dir = ROOT."/assets/products/{$key}";
    echo '<article id="' . $key . '">
          <div class="img" data-item=1 data-items="' . countFolder($dir) . '" onclick="switchProductImg(this)" >
            <img src="' . $dir . '/1.jpg" />
          </div>
        <div>';

    foreach($value["desc"] as $x) {
        echo "<p>" . sanitize($x) . "</p>";
    }

    echo '</div></article>';
}
?>
<script>
<?php
  echo 'const first_prod = "' . array_key_first($text["products"]) . '";';
?>
  document.querySelector("#products article#" + first_prod).classList.add("show");
  document.querySelector("#product-list > div[data-bar="+first_prod+"]").classList.add("show");
</script>
    </div>
    <div id="about">
      <img src="assets/logo.png" loading="lazy" />
      <div>
        <h1><?php echo $text["loc"]["about"]; ?></h1>
<?php
foreach($text["about"] as $x) {
    echo "<p>" . sanitize($x) . "</p>";
}
?>
      </div>
    </div>
    <div id="contact">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58895247.44245157!2d-82.23674428179048!3d25.71499615059859!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xadd28c30ec90d79%3A0x44652457c0696504!2sOcean%20Atlantycki!5e0!3m2!1spl!2spl!4v1696471111526!5m2!1spl!2spl" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      <div class="abc">
        <a href="">
          <svg><use xlink:href="assets/icons.svg#map" /></svg>
          <address>
            Company Sp. z o.o.<br>
            ul. Dziupla 3<br>
            00-000 Home Under The Ground<br>
            NEVERLAND<br>
            <br>
          </address>
        </a>
        <div>
          <svg><use xlink:href="assets/icons.svg#phone" /></svg>
          <a href="tel:+48000000000">+48 00 000 00 00</a><br>
          <a href="tel:+48000000000">+48 000 000 000</a><br>
        </div>
        <a href="mailto:mail@example.com">
          <svg><use xlink:href="assets/icons.svg#mail" /></svg>
          <span>mail@example.com</span>
        </a>
      </div>
    </div>
  </main>

  <footer>
    <div>
      <span id="copyright"> Copyright &copy; <?php echo date("Y"); ?> Company</span>
      <div>
        <a href="/<?php echo LANG; ?>/privacy-policy.php"><?php echo $text["loc"]["privacy"] ?></a>
      </div>
    </div>
  </footer>
</body>
</html>
