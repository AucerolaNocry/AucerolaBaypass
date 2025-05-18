<?php
// Cores básicas
$reset    = "\033[0m";
$bold     = "\033[1m";
$verde    = "\033[32m";
$vermelho = "\033[31m";
$azul     = "\033[36m";

// Função de scanner igual ao KellerSS.php, limpa
function scannerCompleto() {
    global $bold, $verde, $vermelho, $azul, $reset;

    echo $bold . $azul . "[*] Iniciando scanner completo de pastas e arquivos...\n" . $reset;

    $replayPath = "/sdcard/Android/data/com.dts.freefireth/files/MReplays/";
    if (!is_dir($replayPath)) {
        echo $bold . $vermelho . "[!] Pasta de replays não encontrada: $replayPath\n" . $reset;
        return;
    }

    $arquivos = scandir($replayPath);
    $motivos = [];

    foreach ($arquivos as $arquivo) {
        if (in_array($arquivo, ['.', '..'])) continue;
        $caminho = $replayPath . $arquivo;

        if (is_file($caminho)) {
            $info = stat($caminho);
            $acesso     = date("Y-m-d H:i:s", $info['atime']);
            $modificado = date("Y-m-d H:i:s", $info['mtime']);
            $criado     = date("Y-m-d H:i:s", $info['ctime']);

            echo "{$verde}[+] Arquivo: $arquivo\n";
            echo "    Acesso: $acesso\n";
            echo "    Modificado: $modificado\n";
            echo "    Criado: $criado\n";

            if ($info['atime'] != $info['mtime']) {
                $motivos[] = "Arquivo $arquivo teve horário de acesso diferente da modificação.";
            }
        }
    }

    if (!empty($motivos)) {
        echo $bold . $vermelho . "\n[!] Inconsistências encontradas:\n" . $reset;
        foreach ($motivos as $motivo) {
            echo " - $motivo\n";
        }
    } else {
        echo $bold . $verde . "\n[*] Nenhuma inconsistência detectada.\n" . $reset;
    }
}

// Exemplo de execução:
scannerCompleto();
