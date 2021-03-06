<?php
include_once 'ViewDescriptor.php';
include_once basename(__DIR__) . '/../Settings.php';

if (!$vd->isJson()) {
    ?>

<!DOCTYPE html>
 <!--
pagina master, contiene tutto il layout della applicazione
le varie pagine vengono caricate a "pezzi" a seconda della zona
del layout:
- logo (header)
- menu (i tab)
- content (la parte centrale con il contenuto)
- rightBar (sidebar destra)
- footer (footer)

Queste informazioni sono manentute in una struttura dati, chiamata ViewDescriptor
la classe contiene anche le stringhe per i messaggi di feedback per
l'utente (errori e conferme delle operazioni)
-->
<html>
	<head>
		<title><?= $vd->getTitolo() ?></title>
		<base href="<?= Settings::getApplicationPath() ?>php/"/>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png" />
		<?php
            foreach ($vd->getScripts() as $script) {
         	?>
			<script type="text/javascript" src="<?= $script ?>"></script>
			<?php
         }
         ?>

	</head>
	<body>
		<div id="page">
			<header>
				<div id="title">
					<h1>DVDlandia</h1>
				</div>
				<div id="top">
						<?php
                        $logo = $vd->getLogoFile();
                        require "$logo";
                        ?>
				</div>
			</header>

		<div id="sidebar1">
					<h2 id="navigazioneParola">Navigazione</h2>
					<?php
                    $left = $vd->getRightBarFile();
                    require "$left";
                    ?>
                    <h2 id="linkesterni">Link Esterni</h2>
                   	 <ul>
    					<li><a href="http://www.unica.it/">Universit&agrave; di Cagliari</a></li>
    					<li><a href="http://informatica.unica.it/">Facolt&agrave;</a></li>
					 </ul>
					<h2 id="social">Social Network</h2>
					 <ul>
    					<li><a href="http://www.facebook.com/">Facebook</a></li>
    					<li><a href="https://twitter.com/">Twitter</a></li>
					 </ul>
		</div>

 <!-- contenuto -->
		<div id="content">
					<?php
                    if ($vd->getMessaggioErrore() != null) {
                        ?>
			<div class="error">
				<div>
								<?=
                                $vd->getMessaggioErrore();
                                ?>
				</div>
			</div>
					<?php
                    }
                    ?>
					<?php
                    if ($vd->getMessaggioConferma() != null) {
                        ?>
			<div class="confirm">
				<div>
								<?=
                                $vd->getMessaggioConferma();
                                ?>
				</div>
			</div>
					<?php
                    }
                    ?>
					<?php
                    $content = $vd->getContentFile();
                    require "$content";
                    ?>


			</div>

		<div class="clear">
		</div>

			<div id="footer">
				<div id="footertesto">
					<p>
					Applicazione: SerusiSergio
					</p>
					<p>
						<a id="htmlval" href="http://validator.w3.org/check?uri=referer">HTML Valid</a>
						<a id="cssval" href="http://jigsaw.w3.org/css-validator/check/refer">CSS Valid</a>
					</p>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
} else {

    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');

    $content = $vd->getContentFile();
    require "$content";
}
?>
