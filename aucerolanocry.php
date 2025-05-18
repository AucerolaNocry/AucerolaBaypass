
// Prévia do scanner limpo baseado no KellerSS.php

function scannerCompleto() {
    global $bold, $verde, $vermelho, $azul, $reset;

    echo $bold . $azul . "[*] Iniciando scanner completo de pastas e arquivos...
" . $reset;

    $replayPath = "/sdcard/Android/data/com.dts.freefireth/files/MReplays/";
    if (!is_dir($replayPath)) {
        echo $bold . $vermelho . "[!] Pasta de replays não encontrada: $replayPath
" . $reset;
        return;
    }

    $arquivos = scandir($replayPath);
    $motivos = [];

    foreach ($arquivos as $arquivo) {
        if (in_array($arquivo, ['.', '..'])) continue;
        $caminho = $replayPath . $arquivo;

        if (is_file($caminho)) {
            $info = stat($caminho);
            $acesso = date("Y-m-d H:i:s", $info['atime']);
            $modificado = date("Y-m-d H:i:s", $info['mtime']);
            $criado = date("Y-m-d H:i:s", $info['ctime']);

            echo "{$verde}[+] Arquivo: $arquivo
";
            echo "    Acesso: $acesso
";
            echo "    Modificado: $modificado
";
            echo "    Criado: $criado
";

            if ($info['atime'] != $info['mtime']) {
                $motivos[] = "Arquivo $arquivo teve horário de acesso diferente da modificação.";
            }
        }
    }

    if (!empty($motivos)) {
        echo $bold . $vermelho . "
[!] Inconsistências encontradas:
" . $reset;
        foreach ($motivos as $motivo) {
            echo " - $motivo
";
        }
    } else {
        echo $bold . $verde . "
[*] Nenhuma inconsistência detectada.
" . $reset;
    }
}
