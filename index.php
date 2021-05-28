<?php if(empty($_GET)) { ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Corona Zertifikat-Generator</title>
  <link rel="stylesheet" href="style.css" type="text/css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>Corona-Zertifikat-Generator</h1>

<form method="get">
<strong>Arbeitgeber/in Firma/Unternehmen:</strong>
<input type="text" name="FIRMA-NAME" value="Mustermann GmbH">
<input type="text" name="FIRMA-STRASSE-HAUSNR" value="Musterstraße 1">
<input type="text" name="FIRMA-PLZ-ORT" value="12345 Musterstadt">

<strong>Getestete Person</strong>
<input type="text" name="PERSON-NAME" placeholder="Nachname, Vorname" required>
<input type="text" name="PERSON-ADRESS" placeholder="Anschrift" required>
<input type="text" name="PERSON-GEBURTSNAME" placeholder="Geburtsdatum" required>

<strong>Antigen-Schnelltest</strong>
<input type="text" name="TEST-NAME" placeholder="Name des Tests" value="NASOCHECK comfort Antigen-Schnelltest">
<input type="text" name="TEST-HERSTELLER" placeholder="Hersteller" value="LEPU MEDICAL">
<input type="text" name="TEST-DATUM-UHRZEIT" placeholder="Testdatum/Uhrzeit" value="<?php echo date("d.m.Y, H:i") ?>">
<input type="text" name="TEST-PERSON-AUFSICHT" placeholder="Test durchgeführt/beaufsichtigt durch (Name)" required>
<section>Test-Art:
    <input type="hidden" name="XTA" value="">
    <input type="hidden" name="XTS" value="">
    <!-- overwrite: -->
    <label for="XTA"><input type="checkbox" name="XTA" value="X" id="XTA" checked> Antigen-Schnelltest</label>
    <label for="XTS"><input type="checkbox" name="XTS" value="X" id="XTS"> Selbsttest unter Aufsicht</label>
</section>
<section>Testergebnis:
    <input type="hidden" name="XEP" value="">
    <input type="hidden" name="XEN" value="">
    <!-- overwrite: -->
    <label for="XEP"><input type="checkbox" name="XEP" value="X" id="XEP"> Positiv</label>
    <label for="XEN"><input type="checkbox" name="XEN" value="X" id="XEN" checked> Negativ</label>
</section>

<strong>Unterzeichnung</strong>
<input name="TEST-DATUM-UNTERSCHRIFT" placeholder="Datum testende Stelle" value="<?php echo date("d.m.Y") ?>">
<span class="disclaimer">Disclaimer: Wer einen nicht erfolgten Test unrichtig bescheinigt macht sich der Urkundenfälschung
strafbar.</span>

<button type="submit">Test generieren</button>

<script>


</script>

<?php } else {

function slugify($text) { // Just a text slugification
    $text=strip_tags($text);
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    setlocale(LC_ALL, 'en_US.utf8');
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) { return 'n-a'; }
    return $text;
}

# in case not done before...
# exec("cp $workdir/* $basetemplate_dir/");

$workdir = "works"; # without trailing slash
chdir($workdir);
$template = file_get_contents("template.tex");
echo "<pre>";

foreach ($_GET as $key => $value) {
    if(!preg_match('/^[A-Z-]+$/', $key)) die("Wont accept $key as template key."); # avoid latex injections
    if( preg_match('/[\\_%]/',  $value)) die("Wont accept $value as template value."); # avoid even more latex injections
    $template = str_replace($key, $value, $template);
}

$workbase = date("Y-m-d") . "T" . date("H-i") . "N" . slugify($_GET["PERSON-NAME"]);
$worktex = "$workbase.tex";
$outpdf = "$workbase.pdf";
file_put_contents($worktex, $template);

$output = null;
$retval = null;
exec("/usr/bin/pdflatex $worktex", $output, $retval);

if($retval == 0) {
    header("Location: $workdir/$outpdf");
} else {
    echo "<strong>Error at Generating PDF!</strong>";
    
    echo "<table>";
    foreach ($_GET as $key => $value) echo "<tr><th>$key<td>$value\n";
    echo "</table>";

    echo "Latex output is:";
    var_dump($output);
}

}

?>
