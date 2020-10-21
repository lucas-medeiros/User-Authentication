<!DOCTYPE html>
<head><title>MD5 Cracker com Força Bruta</title></head>
<body>
<h2>Teste de algoritmo para quebrar MD5 com força bruta em php</h2>
<pre>
<?php
$goodtext = "Not found";
if ( isset($_GET['crackMD5']) ) {
    $time_pre = microtime(true);

    $txt = "0123456789abcdefghijklmnopqrstuvxwyz";
    $show = 10000;

    $md5 = "";
    $count = 0;

    if($file = fopen('dados.txt', 'r')){
        while ((($buffer = fgets($file, 4096)) !== false) || $count < 4) { //lê as primeiras 4 linhas do arquivo, uma por iteração
            $md5 = substr($buffer, 5, 32); //pega a parte da linha que representa a senha
            print "$md5\n";
            
            for($i=0; $i<strlen($txt); $i++ ) {
                $ch1 = $txt[$i];   

                for($j=0; $j<strlen($txt); $j++ ) {
                    $ch2 = $txt[$j];  

                    for($k=0; $k<strlen($txt); $k++ ) {
                        $ch3 = $txt[$k]; 

                        for($l=0; $l<strlen($txt); $l++ ) {
                            $ch4 = $txt[$l];  

                            $try = $ch1.$ch2.$ch3.$ch4; //monta uma senha tentiva
                            $md5_try = md5($try); //faz o hash ms5 da tentativa

                            if($md5_try == $md5){ //compara as duas
                                $goodtext = $try; //se deu certo salva o texto e sai do loop
                                break;
                            }
                            if($show > 0){ //para debug
                                //echo $md5_try . " " . $try . "\n";
                                //echo var_dump($md5_try) . " " . var_dump($try) . "\n";
                                $show--;
                            }
                        }
                    }
                }
            }
            echo "<p> Pin Original ".$count.": ".$goodtext."</p>"; //imprime a senha descoberta
            echo $md5 . "\n";
            $count++;
        }
        if (!feof($file)) {
            echo "<b>Erro: falha inexperada de fgets()</b>";
        }
        fclose($file);
    } else {
        echo "<b>Não foi possível abrir o arquivo!</b>";
    }

    // Imprime o tempo de excução
    $time_post = microtime(true);
    print "Tempo de execução: ";
    print $time_post - $time_pre;
    print "\n";

    /*
     *
     *  --- Tempos ---
     * t1: 8.3236050605774 s;
     * t2: 8.6567850112915 s;
     * t3: 8.8796608448029 s;
     * Média de tempo: 8.620016972223930 s;
     * -----------------------
     * 
     */ 
}
?>
</pre>
<form>
<input type="submit" value="Crack MD5" name="crackMD5" id="crackMD5"/>
</form>
<ul>
<!-- Para recarregar a página -->
<li><a href="item2.php">Reset</a></li>
</ul>
</body>
</html>