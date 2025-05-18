<?php
// Cores para terminal
$reset    = "\033[0m";
$bold     = "\033[1m";
$verde    = "\033[32m";
$vermelho = "\033[31m";
$azul     = "\033[36m";

// Função de scanner via ADB (sem root)
function scannerViaAdb() {
    global $bold, $verde, $vermelho, $azul, $reset;

    echo $bold . $azul . "[*] Iniciando scanner via ADB...\n" . $reset;

    $replayPath = "/sdcard/Android/data/com.dts.freefireth/files/MReplays/";
    $listaArquivos = shell_exec("adb shell ls \"$replayPath\"");

    if (empty($listaArquivos)) {
        echo $bold . $vermelho . "[!] Nenhum arquivo encontrado ou dispositivo não conectado!\n" . $reset;
        return;
    }

    $arquivos = explode("\n", trim($listaArquivos));
    foreach ($arquivos as $arquivo) {
        $caminho = $replayPath . $arquivo;
        echo $verde . "[+] Arquivo: $arquivo\n";

        $stat = shell_exec("adb shell stat \"$caminho\"");
        if ($stat) {
            echo $azul . $stat . $reset . "\n";
        } else {
            echo $vermelho . "    [!] Erro ao obter informações do arquivo\n" . $reset;
        }
    }
}

// Executa o scanner
scannerViaAdb();
