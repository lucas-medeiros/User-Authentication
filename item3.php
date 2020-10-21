
<div class="row">
    <div">
    <h2> Sistema de Autenticação - Item 3 </h2>
    <p></p>
    <br><hr><br>
    <form action="item3.php" method="POST">
        <div>
            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome">
        </div>
        <br>
        <div>
            <label for="senha">Senha: </label>
            <input type="text" name="senha" id="senha">
        </div>
        <br>
        <div style="padding-left: 50px;">
            <button type="submit" name="btn-login" class="btn">Login</button>
            <button type="submit" name="btn-cadastrar" class="btn">Cadastrar</button>
        </div>
        <br><br><br>
        <div id="result_container">
            <?php
                try {
                    if(isset($_POST["nome"]) && isset($_POST["senha"])){
                        $nome = $_POST["nome"];
                        $senha = $_POST["senha"];
                        if(isset($_POST["btn-login"])){
                            login($nome, $senha);
                        } else if (isset($_POST["btn-cadastrar"])){
                            cadastrar($nome, $senha);
                        } else {
                            echo "";
                        }
                    } else {
                        echo "";
                    }
                } catch (Exception $e){
                    echo "Erro: ".$e;
                }
            ?>
        </div>
    </form>
</div>


<?php
    
    function login($nome, $senha){
        if(empty($nome) || empty($senha)){
            echo "<b>Campos em branco!</b>";
        } else {
            if(strlen($nome) != 4 || strlen($senha) != 4){
                echo "<b>Campos inválidos, nome e senha devem possuir 4 caracteres!</b>";
            } else {
                $login = false; //padrão usuário estar não autenticado
                $line = $nome.";".md5($senha."puc2020puc2020puc2020")."\n";  //monta a linha no formato utilizado no arquivo + adiciona o salt no final
                if($file = fopen('dados.txt', 'r')){
                    while (($buffer = fgets($file, 4096)) !== false) { //lê o arquivo linha a linha, passando o conteúdo para a variável $buffer
                        if($buffer == $line){ //compara, se for igual autentica o usuário
                            $login = true;
                        }
                    }
                    if (!feof($file)) {
                        $login = false;
                        echo "<b>Erro: falha inexperada de fgets()</b>";
                    }
                    fclose($file);
                } else {
                    echo "<b>Não foi possível abrir o arquivo!</b>";
                }
                if($login){
                    echo "<b>Usuário autenticado com sucesso!</b>";
                } else {
                    echo "<b>Nome ou senha incorretos!</b>";
                }
            }
        }
        echo "<br><hr>";
    }

    function cadastrar($nome, $senha){
        if(empty($nome) || empty($senha)){  //comparações para validar o conteúdo dos campos
            echo "<b>Campos em branco!</b>";
        } else {
            if(strlen($nome) != 4 || strlen($senha) != 4){
                echo "<b>Campos inválidos, nome e senha devem possuir 4 caracteres!</b>";
            } else {
                //salt: "puc2020puc2020puc2020" 
                $line = $nome.";".md5($senha."puc2020puc2020puc2020")."\n"; //monta a linha no formato utilizado no arquivo + adiciona o salt no final
                file_put_contents('dados.txt', $line, FILE_APPEND); //adiciona a linha no arquivo
                echo "<b>Usuário cadastrado com sucesso!</b>";
            }
        }
        echo "<br><hr>";
    }

?>
